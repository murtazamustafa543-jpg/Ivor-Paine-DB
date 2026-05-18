

IF NOT EXISTS (SELECT name FROM sys.databases WHERE name = 'HospitalDB_v2')
BEGIN
    CREATE DATABASE HospitalDB_v2;
END;
GO

USE HospitalDB_v2;
GO


IF OBJECT_ID('trg_PreventDeleteSpecialityIfReferenced', 'TR') IS NOT NULL DROP TRIGGER trg_PreventDeleteSpecialityIfReferenced;
IF OBJECT_ID('trg_UpdateWardBedCounts',                 'TR') IS NOT NULL DROP TRIGGER trg_UpdateWardBedCounts;
IF OBJECT_ID('trg_ValidateDoctorDateJoined',            'TR') IS NOT NULL DROP TRIGGER trg_ValidateDoctorDateJoined;
IF OBJECT_ID('trg_PreventDuplicateBedAllocation',       'TR') IS NOT NULL DROP TRIGGER trg_PreventDuplicateBedAllocation;
IF OBJECT_ID('trg_SetBedStatusOnAllocate',              'TR') IS NOT NULL DROP TRIGGER trg_SetBedStatusOnAllocate;
IF OBJECT_ID('trg_SetBedStatusOnDeallocate',            'TR') IS NOT NULL DROP TRIGGER trg_SetBedStatusOnDeallocate;
IF OBJECT_ID('trg_ValidatePatientAge',                  'TR') IS NOT NULL DROP TRIGGER trg_ValidatePatientAge;
IF OBJECT_ID('trg_ValidateExperienceDates',             'TR') IS NOT NULL DROP TRIGGER trg_ValidateExperienceDates;
GO


IF OBJECT_ID('PATIENT_TREATMENT', 'U') IS NOT NULL DROP TABLE PATIENT_TREATMENT;
IF OBJECT_ID('COMPLAINT',         'U') IS NOT NULL DROP TABLE COMPLAINT;
IF OBJECT_ID('PERFORMANCE',       'U') IS NOT NULL DROP TABLE PERFORMANCE;
IF OBJECT_ID('EXPERIENCE',        'U') IS NOT NULL DROP TABLE EXPERIENCE;
IF OBJECT_ID('BED_ALLOCATED',     'U') IS NOT NULL DROP TABLE BED_ALLOCATED;
IF OBJECT_ID('TREATMENT',         'U') IS NOT NULL DROP TABLE TREATMENT;
IF OBJECT_ID('BED',               'U') IS NOT NULL DROP TABLE BED;
IF OBJECT_ID('PATIENT',           'U') IS NOT NULL DROP TABLE PATIENT;
IF OBJECT_ID('DOCTOR',            'U') IS NOT NULL DROP TABLE DOCTOR;
IF OBJECT_ID('NURSE',             'U') IS NOT NULL DROP TABLE NURSE;
IF OBJECT_ID('CARE_UNIT',         'U') IS NOT NULL DROP TABLE CARE_UNIT;
IF OBJECT_ID('WARD',              'U') IS NOT NULL DROP TABLE WARD;
IF OBJECT_ID('STAFF',             'U') IS NOT NULL DROP TABLE STAFF;
IF OBJECT_ID('SPECIALITY',        'U') IS NOT NULL DROP TABLE SPECIALITY;
GO


CREATE TABLE SPECIALITY (
    Speciality_id   INT           NOT NULL PRIMARY KEY,
    Name            VARCHAR(100)  NOT NULL,
    Symbols         VARCHAR(10)   NOT NULL
);
GO


CREATE TABLE STAFF (
    staffID         INT           NOT NULL PRIMARY KEY,
    FName           VARCHAR(50)   NOT NULL,
    MName           VARCHAR(50),
    LName           VARCHAR(50)   NOT NULL,
    CNIC            VARCHAR(20)   NOT NULL UNIQUE,
    DOB             DATE          NOT NULL,
    phoneNumber     VARCHAR(20)   NOT NULL,
    address         VARCHAR(255)  NOT NULL,
    position        VARCHAR(50)   NOT NULL,
    salary          DECIMAL(10,2) NOT NULL CHECK (salary >= 0)
);
GO

CREATE TABLE WARD (
    wardID          INT           NOT NULL PRIMARY KEY,
    Ward_Name       VARCHAR(100)  NOT NULL,
    Speciality_id   INT           NOT NULL,
    Block           VARCHAR(10)   NOT NULL,
    Location        VARCHAR(100)  NOT NULL,
    Contact_No      VARCHAR(20)   NOT NULL,
    Total_Beds      INT           NOT NULL CHECK (Total_Beds >= 0),
    Occupied_Beds   INT           NOT NULL CHECK (Occupied_Beds >= 0),
    Available_Beds  INT           NOT NULL CHECK (Available_Beds >= 0),
    Floor           INT           NOT NULL,
    FOREIGN KEY (Speciality_id) REFERENCES SPECIALITY(Speciality_id)
        ON DELETE NO ACTION
        ON UPDATE CASCADE
);
GO


CREATE TABLE CARE_UNIT (
    unitID          INT            NOT NULL PRIMARY KEY,
    wardID          INT            NOT NULL,
    UnitName        VARCHAR(100)   NOT NULL,
    CostPerDay      DECIMAL(10,2)  NOT NULL CHECK (CostPerDay >= 0),
    Type            VARCHAR(50)    NOT NULL,
    FOREIGN KEY (wardID) REFERENCES WARD(wardID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
GO


CREATE TABLE NURSE (
    NurseID         INT          NOT NULL PRIMARY KEY,
    nurseType       VARCHAR(50)  NOT NULL,
    shift           VARCHAR(20)  NOT NULL CHECK (shift IN ('Morning', 'Afternoon', 'Night')),
    review_date     DATE         NOT NULL,
    CareUnitID      INT          NOT NULL,
    FOREIGN KEY (NurseID)    REFERENCES STAFF(staffID)
        ON DELETE NO ACTION
        ON UPDATE CASCADE,
    FOREIGN KEY (CareUnitID) REFERENCES CARE_UNIT(unitID)
        ON DELETE NO ACTION
        ON UPDATE CASCADE
);
GO


CREATE TABLE DOCTOR (
    DoctorID        INT          NOT NULL PRIMARY KEY,
    ConsultantID    INT,
    position        VARCHAR(50)  NOT NULL,
    datejoined      DATE         NOT NULL,
    speciality_id   INT          NOT NULL,
    wardID          INT          NOT NULL,
    lead_id         INT,
    FOREIGN KEY (DoctorID)      REFERENCES STAFF(staffID)
        ON DELETE NO ACTION
        ON UPDATE CASCADE,
    FOREIGN KEY (speciality_id) REFERENCES SPECIALITY(Speciality_id)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,    -- changed
    FOREIGN KEY (wardID)        REFERENCES WARD(wardID)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,    -- changed
    FOREIGN KEY (lead_id)       REFERENCES DOCTOR(DoctorID)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);
GO


CREATE TABLE PATIENT (
    patientNo       INT           NOT NULL PRIMARY KEY,
    patientName     VARCHAR(100)  NOT NULL,
    dateOfBirth     DATE          NOT NULL,
    age             INT           NOT NULL CHECK (age >= 0),
    dateadmit       DATE          NOT NULL,
    location        VARCHAR(100)  NOT NULL,
    house           VARCHAR(20),
    street          VARCHAR(100),
    zipcode         VARCHAR(20),
    region          VARCHAR(50),
    staffID_Nurse   INT           NOT NULL,
    FOREIGN KEY (staffID_Nurse) REFERENCES NURSE(NurseID)
        ON DELETE NO ACTION
        ON UPDATE CASCADE
);
GO


CREATE TABLE BED (
    bedID           INT          NOT NULL PRIMARY KEY,
    unitID          INT          NOT NULL,
    bedType         VARCHAR(50)  NOT NULL,
    status          VARCHAR(20)  NOT NULL CHECK (status IN ('Available', 'Occupied', 'Under Maintenance')),
    FOREIGN KEY (unitID) REFERENCES CARE_UNIT(unitID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
GO


CREATE TABLE BED_ALLOCATED (
    bedID           INT          NOT NULL,
    patientNo       INT          NOT NULL,
    duration        INT          NOT NULL CHECK (duration > 0),
    PRIMARY KEY (bedID, patientNo),
    FOREIGN KEY (bedID)     REFERENCES BED(bedID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (patientNo) REFERENCES PATIENT(patientNo)
        ON DELETE NO ACTION   
        ON UPDATE NO ACTION  
);
GO


CREATE TABLE PERFORMANCE (
    DoctorID        INT          NOT NULL,
    review_date     DATE         NOT NULL,
    grade           VARCHAR(5)   NOT NULL,
    PRIMARY KEY (DoctorID, review_date),
    FOREIGN KEY (DoctorID) REFERENCES DOCTOR(DoctorID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
GO

CREATE TABLE EXPERIENCE (
    expID           INT           NOT NULL PRIMARY KEY,
    DoctorID        INT           NOT NULL,
    establishment   VARCHAR(100)  NOT NULL,
    position_held   VARCHAR(100)  NOT NULL,
    from_date       DATE          NOT NULL,
    to_date         DATE,
    staffID         INT           NOT NULL,
    FOREIGN KEY (DoctorID) REFERENCES DOCTOR(DoctorID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (staffID)  REFERENCES STAFF(staffID)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION   -- changed
);
GO

CREATE TABLE TREATMENT (
    treatmentno     INT           NOT NULL PRIMARY KEY,
    treatmentname   VARCHAR(100)  NOT NULL,
    description     TEXT,
    Type            VARCHAR(50)   NOT NULL,
    speciality_id   INT           NOT NULL,
    FOREIGN KEY (speciality_id) REFERENCES SPECIALITY(Speciality_id)
        ON DELETE NO ACTION
        ON UPDATE CASCADE
);
GO


CREATE TABLE COMPLAINT (
    complaintno     INT           NOT NULL PRIMARY KEY,
    patientNo       INT           NOT NULL,
    staffID_Dr      INT           NOT NULL,
    description     TEXT          NOT NULL,
    severity        VARCHAR(20)   NOT NULL CHECK (severity IN ('Low', 'Medium', 'High', 'Critical')),
    dateReported    DATE          NOT NULL,
    location        VARCHAR(100)  NOT NULL,
    FOREIGN KEY (patientNo)  REFERENCES PATIENT(patientNo)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (staffID_Dr) REFERENCES DOCTOR(DoctorID)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION   -- changed
);
GO


CREATE TABLE PATIENT_TREATMENT (
    patientNo       INT          NOT NULL,
    treatmentno     INT          NOT NULL,
    complaintno     INT          NOT NULL,
    DoctorID        INT          NOT NULL,
    duration        INT          NOT NULL CHECK (duration > 0),
    PRIMARY KEY (patientNo, treatmentno),
    FOREIGN KEY (patientNo)   REFERENCES PATIENT(patientNo)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (treatmentno) REFERENCES TREATMENT(treatmentno)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,  -- changed
    FOREIGN KEY (complaintno) REFERENCES COMPLAINT(complaintno)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    FOREIGN KEY (DoctorID)    REFERENCES DOCTOR(DoctorID)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION   -- changed
);
GO



CREATE TRIGGER trg_PreventDeleteSpecialityIfReferenced
ON SPECIALITY
INSTEAD OF DELETE
AS
BEGIN
    IF EXISTS (
        SELECT 1 FROM WARD      WHERE Speciality_id IN (SELECT Speciality_id FROM deleted)
        UNION
        SELECT 1 FROM DOCTOR    WHERE speciality_id  IN (SELECT Speciality_id FROM deleted)
        UNION
        SELECT 1 FROM TREATMENT WHERE speciality_id  IN (SELECT Speciality_id FROM deleted)
    )
    BEGIN
        RAISERROR('Cannot delete SPECIALITY: it is still referenced by WARD, DOCTOR, or TREATMENT.', 16, 1);
        ROLLBACK TRANSACTION;
        RETURN;
    END
    DELETE FROM SPECIALITY WHERE Speciality_id IN (SELECT Speciality_id FROM deleted);
END;
GO

CREATE TRIGGER trg_UpdateWardBedCounts
ON BED
AFTER INSERT, UPDATE, DELETE
AS
BEGIN
    SET NOCOUNT ON;
    DECLARE @affectedWards TABLE (wardID INT);

    INSERT INTO @affectedWards (wardID)
    SELECT DISTINCT cu.wardID
    FROM CARE_UNIT cu
    WHERE cu.unitID IN (
        SELECT unitID FROM inserted
        UNION
        SELECT unitID FROM deleted
    );

    UPDATE w
    SET
        Total_Beds     = (SELECT COUNT(*)   FROM BED b JOIN CARE_UNIT cu ON b.unitID = cu.unitID WHERE cu.wardID = w.wardID),
        Occupied_Beds  = (SELECT COUNT(*)   FROM BED b JOIN CARE_UNIT cu ON b.unitID = cu.unitID WHERE cu.wardID = w.wardID AND b.status = 'Occupied'),
        Available_Beds = (SELECT COUNT(*)   FROM BED b JOIN CARE_UNIT cu ON b.unitID = cu.unitID WHERE cu.wardID = w.wardID AND b.status = 'Available')
    FROM WARD w
    WHERE w.wardID IN (SELECT wardID FROM @affectedWards);
END;
GO


CREATE TRIGGER trg_ValidateDoctorDateJoined
ON DOCTOR
AFTER INSERT, UPDATE
AS
BEGIN
    IF EXISTS (SELECT 1 FROM inserted WHERE datejoined > CAST(GETDATE() AS DATE))
    BEGIN
        RAISERROR('DOCTOR datejoined cannot be a future date.', 16, 1);
        ROLLBACK TRANSACTION;
        RETURN;
    END
END;
GO

CREATE TRIGGER trg_PreventDuplicateBedAllocation
ON BED_ALLOCATED
AFTER INSERT
AS
BEGIN
    IF EXISTS (
        SELECT patientNo FROM BED_ALLOCATED
        WHERE patientNo IN (SELECT patientNo FROM inserted)
        GROUP BY patientNo
        HAVING COUNT(*) > 1
    )
    BEGIN
        RAISERROR('A patient can only be allocated one bed at a time.', 16, 1);
        ROLLBACK TRANSACTION;
        RETURN;
    END
END;
GO


CREATE TRIGGER trg_SetBedStatusOnAllocate
ON BED_ALLOCATED
AFTER INSERT
AS
BEGIN
    SET NOCOUNT ON;
    UPDATE BED SET status = 'Occupied'
    WHERE bedID IN (SELECT bedID FROM inserted);
END;
GO


CREATE TRIGGER trg_SetBedStatusOnDeallocate
ON BED_ALLOCATED
AFTER DELETE
AS
BEGIN
    SET NOCOUNT ON;
    UPDATE BED SET status = 'Available'
    WHERE bedID IN (SELECT bedID FROM deleted);
END;
GO


CREATE TRIGGER trg_ValidatePatientAge
ON PATIENT
AFTER INSERT, UPDATE
AS
BEGIN
    IF EXISTS (
        SELECT 1 FROM inserted
        WHERE age <> DATEDIFF(YEAR, dateOfBirth, GETDATE())
              - CASE
                    WHEN MONTH(dateOfBirth) > MONTH(GETDATE())
                      OR (MONTH(dateOfBirth) = MONTH(GETDATE()) AND DAY(dateOfBirth) > DAY(GETDATE()))
                    THEN 1 ELSE 0
                END
    )
    BEGIN
        RAISERROR('PATIENT age does not match dateOfBirth.', 16, 1);
        ROLLBACK TRANSACTION;
        RETURN;
    END
END;
GO

CREATE TRIGGER trg_ValidateExperienceDates
ON EXPERIENCE
AFTER INSERT, UPDATE
AS
BEGIN
    IF EXISTS (
        SELECT 1 FROM inserted
        WHERE to_date IS NOT NULL AND from_date >= to_date
    )
    BEGIN
        RAISERROR('EXPERIENCE from_date must be earlier than to_date.', 16, 1);
        ROLLBACK TRANSACTION;
        RETURN;
    END
END;
GO