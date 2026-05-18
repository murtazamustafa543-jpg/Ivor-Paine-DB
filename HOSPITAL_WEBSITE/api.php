<?php

//backend , queries

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
require_once __DIR__ . '/includes/db.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {

    
    case 'dashboard':
        echo json_encode([
            'patients'  => queryOne("SELECT COUNT(*) AS n FROM PATIENT")['n'],
            'doctors'   => queryOne("SELECT COUNT(*) AS n FROM DOCTOR")['n'],
            'nurses'    => queryOne("SELECT COUNT(*) AS n FROM NURSE")['n'],
            'wards'     => queryOne("SELECT COUNT(*) AS n FROM WARD")['n'],
            'beds_available' => queryOne("SELECT SUM(Available_Beds) AS n FROM WARD")['n'],
            'beds_occupied'  => queryOne("SELECT SUM(Occupied_Beds)  AS n FROM WARD")['n'],
            'complaints'     => queryOne("SELECT COUNT(*) AS n FROM COMPLAINT")['n'],
            'treatments'     => queryOne("SELECT COUNT(*) AS n FROM PATIENT_TREATMENT")['n'],
        ]);
        break;

   
    // REPORTS / QUERIES (the 12 required)
    
    // Q1 Consultants and their teams
    case 'q1_consultant_teams':
        $rows = queryRows("
            SELECT
                c.DoctorID                        AS consultant_id,
                sc.FName + ' ' + sc.LName         AS consultant_name,
                sp.Name                           AS speciality,
                d.DoctorID                        AS doctor_id,
                sd.FName + ' ' + sd.LName         AS doctor_name,
                d.position                        AS doctor_position,
                d.datejoined
            FROM DOCTOR c
            JOIN STAFF  sc ON c.DoctorID   = sc.staffID
            JOIN SPECIALITY sp ON c.speciality_id = sp.Speciality_id
            JOIN DOCTOR d  ON d.lead_id    = c.DoctorID
            JOIN STAFF  sd ON d.DoctorID   = sd.staffID
            WHERE c.ConsultantID IS NOT NULL
               OR c.position IN ('Consultant','consultant')
            ORDER BY consultant_name, doctor_name
        ");
        echo json_encode($rows);
        break;

    // Q2  Wards with sisters, care units, staff nurses
    case 'q2_ward_details':
        $rows = queryRows("
            SELECT
                w.wardID,
                w.Ward_Name,
                sp.Name                         AS speciality,
                w.Block, w.Floor,
                w.Total_Beds, w.Available_Beds, w.Occupied_Beds,
                cu.unitID, cu.UnitName, cu.Type  AS unit_type,
                cu.CostPerDay,
                n.NurseID,
                sn.FName + ' ' + sn.LName        AS nurse_name,
                n.nurseType, n.shift
            FROM WARD w
            JOIN SPECIALITY sp ON w.Speciality_id = sp.Speciality_id
            JOIN CARE_UNIT cu  ON cu.wardID        = w.wardID
            JOIN NURSE n       ON n.CareUnitID     = cu.unitID
            JOIN STAFF sn      ON n.NurseID        = sn.staffID
            ORDER BY w.Ward_Name, cu.UnitName, n.nurseType
        ");
        echo json_encode($rows);
        break;

    // Q3  Patients, complaints, treatments
    case 'q3_patient_treatments':
        $rows = queryRows("
            SELECT
                p.patientNo,
                p.patientName,
                p.dateadmit,
                c.complaintno,
                c.description  AS complaint_desc,
                c.severity,
                c.dateReported,
                t.treatmentname,
                t.Type          AS treatment_type,
                pt.duration,
                sd.FName + ' ' + sd.LName AS doctor_name
            FROM PATIENT p
            JOIN COMPLAINT        c  ON c.patientNo   = p.patientNo
            JOIN PATIENT_TREATMENT pt ON pt.patientNo = p.patientNo
                                     AND pt.complaintno = c.complaintno
            JOIN TREATMENT        t  ON t.treatmentno = pt.treatmentno
            JOIN DOCTOR           d  ON d.DoctorID    = pt.DoctorID
            JOIN STAFF            sd ON sd.staffID    = d.DoctorID
            ORDER BY p.patientName, c.dateReported
        ");
        echo json_encode($rows);
        break;

    // Q4  Junior housemen, their patients, staff nurse of care unit
    case 'q4_junior_housemen':
        $rows = queryRows("
            SELECT
                d.DoctorID,
                sd.FName + ' ' + sd.LName   AS doctor_name,
                d.position,
                p.patientNo,
                p.patientName,
                p.dateadmit,
                sn.FName + ' ' + sn.LName   AS staff_nurse,
                n.shift,
                cu.UnitName
            FROM DOCTOR d
            JOIN STAFF  sd ON sd.staffID   = d.DoctorID
            JOIN PATIENT_TREATMENT pt ON pt.DoctorID = d.DoctorID
            JOIN PATIENT p   ON p.patientNo  = pt.patientNo
            JOIN NURSE  n    ON n.NurseID    = p.staffID_Nurse
            JOIN STAFF  sn   ON sn.staffID   = n.NurseID
            JOIN CARE_UNIT cu ON cu.unitID   = n.CareUnitID
            WHERE LOWER(d.position) IN ('jh','junior houseman','junior house man','j.h.','houseman')
            ORDER BY doctor_name, p.patientName
        ");
        echo json_encode($rows);
        break;

    // Q5  Consultants with a unique speciality
    case 'q5_unique_speciality':
        $rows = queryRows("
            SELECT 
                d.DoctorID,
                s.FName + ' ' + s.LName  AS consultant_name,
                sp.Name                   AS speciality,
                sp.symbols                 AS speciality_symbol,
                s.position,
                d.datejoined
            FROM DOCTOR d
            JOIN STAFF      s  ON s.staffID        = d.DoctorID
            JOIN SPECIALITY sp ON sp.Speciality_id = d.speciality_id
            WHERE d.position = 'Consultant'
            AND d.speciality_id IN (
                SELECT speciality_id
                FROM DOCTOR
                WHERE position = 'Consultant'
                GROUP BY speciality_id
                HAVING COUNT(*) = 1
            )
            ORDER BY consultant_name;
        ");
        echo json_encode($rows);
        break;

    // Q6 Complaints, treatments, doctor experience
    case 'q6_complaint_treatment_exp':
        $rows = queryRows("
            SELECT
                c.complaintno,
                c.description   AS complaint_desc,
                c.severity,
                t.treatmentname,
                t.Type          AS treatment_type,
                sd.FName + ' ' + sd.LName  AS doctor_name,
                e.establishment,
                e.position_held,
                e.from_date,
                e.to_date
            FROM COMPLAINT c
            JOIN PATIENT_TREATMENT pt ON pt.complaintno = c.complaintno
            JOIN TREATMENT         t  ON t.treatmentno  = pt.treatmentno
            JOIN DOCTOR            d  ON d.DoctorID     = pt.DoctorID
            JOIN STAFF             sd ON sd.staffID     = d.DoctorID
            LEFT JOIN EXPERIENCE   e  ON e.DoctorID     = d.DoctorID
            ORDER BY c.complaintno, t.treatmentname
        ");
        echo json_encode($rows);
        break;

    // Q7  Patients with more than one complaint
case 'q7_multi_complaint':
    $patients = queryRows("
        SELECT
            p.patientNo,
            p.patientName,
            p.age,
            COUNT(DISTINCT c.complaintno) AS total_complaints,
            (
                SELECT STRING_AGG(CAST(c2.complaintno AS VARCHAR) + ': ' + LEFT(c2.description, 40), ' | ')
                FROM (SELECT DISTINCT complaintno, CAST(description AS VARCHAR(255)) AS description 
                      FROM COMPLAINT WHERE patientNo = p.patientNo) c2
            ) AS complaints,
            (
                SELECT STRING_AGG(t2.treatmentname, ', ')
                FROM (SELECT DISTINCT t3.treatmentname FROM PATIENT_TREATMENT pt2
                      JOIN TREATMENT t3 ON t3.treatmentno = pt2.treatmentno
                      WHERE pt2.patientNo = p.patientNo) t2
            ) AS treatments
        FROM PATIENT p
        JOIN COMPLAINT         c  ON c.patientNo  = p.patientNo
        JOIN PATIENT_TREATMENT pt ON pt.patientNo = p.patientNo
        JOIN TREATMENT         t  ON t.treatmentno = pt.treatmentno
        GROUP BY
            p.patientNo,
            p.patientName,
            p.age
        HAVING COUNT(DISTINCT c.complaintno) > 1
        ORDER BY total_complaints DESC
    ");
    echo json_encode($patients);
    break;


    // Q8  Patients grouped by treatment within complaint
    case 'q8_grouped_by_treatment':
        $rows = queryRows("
                SELECT
            c.complaintno,
            CAST(c.description AS VARCHAR(255))  AS complaint_desc,
            t.treatmentno,
            t.treatmentname,
            t.Type                               AS treatment_type,
            p.patientNo,
            p.patientName,
            pt.duration,
            sd.FName + ' ' + sd.LName           AS doctor_name
        FROM COMPLAINT c
        JOIN PATIENT_TREATMENT pt ON pt.complaintno  = c.complaintno
        JOIN PATIENT           p  ON p.patientNo     = pt.patientNo
        JOIN TREATMENT         t  ON t.treatmentno   = pt.treatmentno
        JOIN DOCTOR            d  ON d.DoctorID      = pt.DoctorID
        JOIN STAFF             sd ON sd.staffID      = d.DoctorID
        ORDER BY c.complaintno, t.treatmentname, p.patientName
        ");
        echo json_encode($rows);
        break;

    // Q9  Performance history for a doctor
    case 'q9_performance':
        $id   = intval($_GET['doctor_id'] ?? 0);
        $rows = queryRows("
            SELECT
                s.FName + ' ' + s.LName   AS doctor_name,
                d.position,
                sp.Name                   AS speciality,
                p.review_date,
                p.grade
            FROM DOCTOR d
            JOIN STAFF     s  ON s.staffID        = d.DoctorID
            JOIN SPECIALITY sp ON sp.Speciality_id = d.speciality_id
            JOIN PERFORMANCE p ON p.DoctorID       = d.DoctorID
            WHERE d.DoctorID = ?
            ORDER BY p.review_date
        ", [$id]);
        echo json_encode($rows);
        break;

    // Q10 Full medical details for a patient
    case 'q10_patient_details':
        $id = intval($_GET['patient_id'] ?? 0);
        $p  = queryOne("
            SELECT p.*,
                   sn.FName + ' ' + sn.LName AS nurse_name,
                   n.nurseType, n.shift,
                   cu.UnitName, w.Ward_Name
            FROM PATIENT p
            JOIN NURSE     n  ON n.NurseID     = p.staffID_Nurse
            JOIN STAFF     sn ON sn.staffID    = n.NurseID
            JOIN CARE_UNIT cu ON cu.unitID     = n.CareUnitID
            JOIN WARD      w  ON w.wardID      = cu.wardID
            WHERE p.patientNo = ?
        ", [$id]);
        $complaints = queryRows("
            SELECT c.*,
                   t.treatmentname, t.Type AS treatment_type,
                   pt.duration,
                   sd.FName + ' ' + sd.LName AS doctor_name,
                   d.position AS doctor_position
            FROM COMPLAINT c
            JOIN PATIENT_TREATMENT pt ON pt.complaintno = c.complaintno
                                     AND pt.patientNo   = c.patientNo
            JOIN TREATMENT t  ON t.treatmentno = pt.treatmentno
            JOIN DOCTOR    d  ON d.DoctorID    = pt.DoctorID
            JOIN STAFF     sd ON sd.staffID    = d.DoctorID
            WHERE c.patientNo = ?
            ORDER BY c.dateReported
        ", [$id]);
        $bed = queryOne("
            SELECT b.bedID, b.bedType, cu.UnitName, w.Ward_Name, ba.duration
            FROM BED_ALLOCATED ba
            JOIN BED       b  ON b.bedID    = ba.bedID
            JOIN CARE_UNIT cu ON cu.unitID  = b.unitID
            JOIN WARD      w  ON w.wardID   = cu.wardID
            WHERE ba.patientNo = ?
        ", [$id]);
        echo json_encode(['patient' => $p, 'complaints' => $complaints, 'bed' => $bed]);
        break;

    // Q11 Treatments for a complaint between dates
    case 'q11_treatments_by_dates':
        $cid  = $_GET['complaint_id'] ?? '';
        $from = $_GET['from'] ?? '1900-01-01';
        $to   = $_GET['to']   ?? date('Y-m-d'); 

        if (!$cid) { echo json_encode([]); break; }

        $result = queryRows("
            SELECT
                t.treatmentno,
                t.treatmentname,
                t.Type                               AS treatment_type,
                CAST(t.description AS VARCHAR(255))  AS treatment_desc,
                c.complaintno,
                CAST(c.description AS VARCHAR(255))  AS complaint_desc,
                c.dateReported,
                p.patientName,
                sd.FName + ' ' + sd.LName           AS doctor_name,
                pt.duration
            FROM PATIENT_TREATMENT pt
            JOIN TREATMENT t  ON t.treatmentno = pt.treatmentno
            JOIN COMPLAINT c  ON c.complaintno = pt.complaintno
            JOIN PATIENT   p  ON p.patientNo   = pt.patientNo
            JOIN DOCTOR    d  ON d.DoctorID    = pt.DoctorID
            JOIN STAFF     sd ON sd.staffID    = d.DoctorID
            WHERE pt.complaintno = ?
            AND c.dateReported BETWEEN ? AND ?
            ORDER BY t.treatmentname, c.dateReported
        ", [$cid, $from, $to]);

        echo json_encode($result);
        break;

    // Q12 Staff positions and count
    case 'q12_staff_positions':
        $rows = queryRows("
            SELECT position, COUNT(*) AS staff_count
            FROM STAFF
            GROUP BY position
            ORDER BY staff_count DESC
        ");
        echo json_encode($rows);
        break;

    
    // FORMS 
    

    // PATIENT RECORD (Form 1)
    case 'get_patient_record':
        $id = intval($_GET['patient_id'] ?? 0);
        $p  = queryOne("
            SELECT p.*,
                   sn.FName + ' ' + sn.LName  AS nurse_name,
                   n.nurseType,
                   cu.UnitName
            FROM PATIENT p
            JOIN NURSE n    ON n.NurseID    = p.staffID_Nurse
            JOIN STAFF sn   ON sn.staffID   = n.NurseID
            JOIN CARE_UNIT cu ON cu.unitID  = n.CareUnitID
            WHERE p.patientNo = ?
        ", [$id]);
        
        $doc = queryOne("
            SELECT TOP 1
                   sd.FName + ' ' + sd.LName  AS doctor_name,
                   d.DoctorID,
                   d.ConsultantID,
                   sc.FName + ' ' + sc.LName  AS consultant_name
            FROM PATIENT_TREATMENT pt
            JOIN DOCTOR d  ON d.DoctorID   = pt.DoctorID
            JOIN STAFF  sd ON sd.staffID   = d.DoctorID
            LEFT JOIN DOCTOR dc ON dc.DoctorID = d.lead_id
            LEFT JOIN STAFF  sc ON sc.staffID  = dc.DoctorID
            WHERE pt.patientNo = ?
        ", [$id]);
        $history = queryRows("
            SELECT c.complaintno, LEFT(CAST(c.description AS VARCHAR(255)), 60) AS complaint,
                   t.treatmentname, pt.duration,
                   sd.FName + ' ' + sd.LName AS doctor,
                   c.dateReported
            FROM COMPLAINT c
            JOIN PATIENT_TREATMENT pt ON pt.complaintno = c.complaintno
                                     AND pt.patientNo   = c.patientNo
            JOIN TREATMENT t ON t.treatmentno = pt.treatmentno
            JOIN DOCTOR    d ON d.DoctorID    = pt.DoctorID
            JOIN STAFF    sd ON sd.staffID    = d.DoctorID
            WHERE c.patientNo = ?
            ORDER BY c.dateReported
        ", [$id]);
        echo json_encode(['patient' => $p, 'doctor' => $doc, 'history' => $history]);
        break;

    // WARD RECORD (Form 2)
    case 'get_ward_record':
        $wardName = $_GET['ward_name'] ?? '';
        $w = queryOne("
            SELECT w.*, sp.Name AS speciality_name
            FROM WARD w
            JOIN SPECIALITY sp ON sp.Speciality_id = w.Speciality_id
            WHERE w.Ward_Name LIKE ?
        ", ["%$wardName%"]);
        if (!$w) { echo json_encode(null); break; }
        $nurses = queryRows("
            SELECT n.NurseID, sn.FName + ' ' + sn.LName AS nurse_name,
                   n.nurseType, n.shift, cu.UnitName
            FROM NURSE n
            JOIN STAFF     sn ON sn.staffID   = n.NurseID
            JOIN CARE_UNIT cu ON cu.unitID    = n.CareUnitID
            WHERE cu.wardID = ?
            ORDER BY n.nurseType
        ", [$w['wardID']]);
        $patients = queryRows("
            SELECT p.patientNo, p.patientName, cu.UnitName,
                   b.bedID, p.dateadmit,
                   sd.FName + ' ' + sd.LName AS consultant
            FROM PATIENT p
            JOIN NURSE     n   ON n.NurseID    = p.staffID_Nurse
            JOIN CARE_UNIT cu  ON cu.unitID    = n.CareUnitID
            LEFT JOIN BED_ALLOCATED ba ON ba.patientNo = p.patientNo
            LEFT JOIN BED  b           ON b.bedID      = ba.bedID
            LEFT JOIN PATIENT_TREATMENT pt ON pt.patientNo = p.patientNo
            LEFT JOIN DOCTOR d   ON d.DoctorID  = pt.DoctorID AND d.ConsultantID IS NOT NULL
            LEFT JOIN STAFF  sd  ON sd.staffID  = d.DoctorID
            WHERE cu.wardID = ?
        ", [$w['wardID']]);
        echo json_encode(['ward' => $w, 'nurses' => $nurses, 'patients' => $patients]);
        break;

    // CONSULTANT TEAM RECORD (Form 3)
    case 'get_consultant_team':
        $staffNo = intval($_GET['staff_id'] ?? 0);
        $doc = queryOne("
            SELECT d.*, s.FName, s.MName, s.LName, s.CNIC,
                   s.DOB, s.phoneNumber, s.address, s.salary,
                   sp.Name AS speciality_name
            FROM DOCTOR d
            JOIN STAFF     s  ON s.staffID        = d.DoctorID
            JOIN SPECIALITY sp ON sp.Speciality_id = d.speciality_id
            WHERE d.DoctorID = ?
        ", [$staffNo]);
        if (!$doc) { echo json_encode(null); break; }
        $exp = queryRows("
            SELECT * FROM EXPERIENCE WHERE DoctorID = ? ORDER BY from_date
        ", [$staffNo]);
        $perf = queryRows("
            SELECT review_date, grade FROM PERFORMANCE WHERE DoctorID = ? ORDER BY review_date
        ", [$staffNo]);
        echo json_encode(['doctor' => $doc, 'experience' => $exp, 'performance' => $perf]);
        break;

    // LIST helpers for dropdowns
    case 'search_patients':
        $q = '%' . ($_GET['q'] ?? '') . '%';
        echo json_encode(queryRows(
            "SELECT TOP 20 patientNo, patientName FROM PATIENT WHERE patientName LIKE ? ORDER BY patientName",
            [$q]
        ));
        break;

    case 'list_patients':
        echo json_encode(queryRows("SELECT patientNo, patientName FROM PATIENT ORDER BY patientName"));
        break;
    case 'list_doctors':
        echo json_encode(queryRows("SELECT d.DoctorID, s.FName+' '+s.LName AS name, d.position FROM DOCTOR d JOIN STAFF s ON s.staffID=d.DoctorID ORDER BY name"));
        break;
    case 'list_wards':
        echo json_encode(queryRows("SELECT wardID, Ward_Name FROM WARD ORDER BY Ward_Name"));
        break;
    case 'list_complaints':
        echo json_encode(queryRows("SELECT complaintno, LEFT(CAST(description AS VARCHAR(255)), 50) AS label FROM COMPLAINT ORDER BY complaintno"));
        break;

    default:
        echo json_encode(['error' => 'Unknown action: ' . $action]);
}