USE HospitalDB_v2;
GO

-- Disable trigger temporarily
DISABLE TRIGGER trg_ValidatePatientAge ON PATIENT;
GO

-- Clear in FK-safe order
DELETE FROM PATIENT_TREATMENT;
DELETE FROM COMPLAINT;
DELETE FROM BED_ALLOCATED;
DELETE FROM BED;
DELETE FROM PATIENT;
DELETE FROM PERFORMANCE;
DELETE FROM EXPERIENCE;
DELETE FROM DOCTOR;
DELETE FROM NURSE;
DELETE FROM CARE_UNIT;
DELETE FROM WARD;
DELETE FROM TREATMENT;
DELETE FROM STAFF;
DELETE FROM SPECIALITY;
GO

-- Re-enable trigger
ENABLE TRIGGER trg_ValidatePatnitAge ON PATIENT;
GO



INSERT INTO SPECIALITY (Speciality_id, Name, Symbols) VALUES
(1,  'Cardiology',         'CARD'),
(2,  'Neurology',          'NEUR'),
(3,  'Orthopedics',        'ORTH'),
(4,  'Pediatrics',         'PEDI'),
(5,  'Gynecology',         'GYNE'),
(6,  'Dermatology',        'DERM'),
(7,  'Oncology',           'ONCO'),
(8,  'Gastroenterology',   'GAST'),
(9,  'Pulmonology',        'PULM'),
(10, 'Emergency Medicine', 'EMRG');
GO


INSERT INTO STAFF (staffID, FName, MName, LName, CNIC, DOB, phoneNumber, address, position, salary) VALUES

(1,  'Asad',     'Ali',     'Khan',      '35202-1234567-1', '1968-03-12', '0300-1234567', 'House 5, Gulberg, Lahore',           'Consultant',          350000.00),
(2,  'Farrukh',  'Ahmed',   'Siddiqui',  '42101-2345678-2', '1970-07-22', '0301-2345678', 'Flat 3B, Clifton, Karachi',          'Consultant',          370000.00),
(3,  'Nadia',    'Tariq',   'Mahmood',   '37405-3456789-3', '1972-11-05', '0302-3456789', 'Street 7, F-8, Islamabad',           'Consultant',          360000.00),
(4,  'Bilal',    'Usman',   'Chaudhry',  '35301-4567890-4', '1979-01-30', '0303-4567890', 'House 12, DHA Phase 2, Lahore',      'Registrar',           200000.00),
(5,  'Sana',     'Irfan',   'Qureshi',   '42201-5678901-5', '1980-06-18', '0304-5678901', 'Apt 6, Bath Island, Karachi',        'Registrar',           195000.00),
(6,  'Imran',    'Raza',    'Butt',      '38403-6789012-6', '1983-09-25', '0305-6789012', 'House 9, Cantt, Rawalpindi',         'Assistant Registrar', 160000.00),
(7,  'Hina',     'Babar',   'Malik',     '35202-7890123-7', '1984-04-14', '0306-7890123', 'House 22, Model Town, Lahore',       'Assistant Registrar', 155000.00),
(8,  'Zubair',   'Hassan',  'Sheikh',    '42301-8901234-8', '1987-12-03', '0307-8901234', 'House 45, PECHS, Karachi',           'Senior Houseman',     120000.00),
(9,  'Rabia',    'Noman',   'Ansari',    '61101-9012345-9', '1988-02-28', '0308-9012345', 'House 3, G-10, Islamabad',           'Senior Houseman',     115000.00),
(10, 'Tariq',    'Saleem',  'Awan',      '35401-0123456-0', '1992-08-17', '0309-0123456', 'House 77, Johar Town, Lahore',       'Junior Houseman',      85000.00),
(55, 'Kamran',   'Yusuf',   'Shah',      '35202-5555001-1', '1993-05-21', '0300-5550011', 'House 3, Gulshan, Lahore',           'Junior Houseman',      82000.00),
(56, 'Mariam',   'Iqbal',   'Paracha',   '42101-5555002-2', '1998-02-10', '0301-5550022', 'Flat 2, North Nazimabad, Karachi',   'Student',              45000.00),
(57, 'Usman',    'Bashir',  'Gondal',    '37405-5555003-3', '1999-07-15', '0302-5550033', 'House 6, E-11, Islamabad',           'Student',              43000.00),
(11, 'Ayesha',   'Bano',    'Rizvi',     '35202-1111111-1', '1985-05-10', '0310-1111111', 'House 2, Gulshan, Lahore',           'Day Sister',           95000.00),
(12, 'Zainab',   'Ali',     'Hussain',   '42101-2222222-2', '1983-09-15', '0311-2222222', 'Flat 5, North Nazimabad, Karachi',   'Day Sister',           93000.00),
(13, 'Mariam',   'Arif',    'Farooqi',   '37405-3333333-3', '1984-03-22', '0312-3333333', 'House 8, I-9, Islamabad',            'Day Sister',           92000.00),
(14, 'Saima',    'Khalid',  'Baig',      '35301-4444444-4', '1986-07-30', '0313-4444444', 'House 14, Shadman, Lahore',          'Night Sister',         90000.00),
(15, 'Faiza',    'Noor',    'Ahmed',     '42201-5555555-5', '1987-11-08', '0314-5555555', 'Flat 2A, Gulistan-e-Johar, Karachi', 'Night Sister',         88000.00),
(16, 'Rubina',   'Parveen', 'Javed',     '38403-6666666-6', '1985-01-25', '0315-6666666', 'House 6, Satellite Town, Rwp',       'Night Sister',         89000.00),
(17, 'Huma',     'Shafiq',  'Mirza',     '35202-7777777-7', '1990-06-12', '0316-7777777', 'House 19, Garden Town, Lahore',      'Staff Nurse',          80000.00),
(18, 'Noor',     'Fatima',  'Syed',      '42301-8888888-8', '1991-04-05', '0317-8888888', 'House 33, Malir, Karachi',           'Staff Nurse',          78000.00),
(19, 'Amna',     'Zahid',   'Chaudhry',  '61101-9999999-9', '1989-08-20', '0318-9999999', 'House 7, F-7, Islamabad',            'Staff Nurse',          79000.00),
(20, 'Sobia',    'Nasir',   'Bajwa',     '35401-1010101-0', '1988-12-17', '0319-1010101', 'House 55, Wapda Town, Lahore',       'Staff Nurse',          81000.00),
(21, 'Uzma',     'Rafiq',   'Dar',       '35202-1212121-2', '1992-02-14', '0320-1212121', 'Flat 9, Defence, Karachi',           'Staff Nurse',          77000.00),
(22, 'Tahira',   'Aziz',    'Hashmi',    '37405-1313131-3', '1991-10-03', '0321-1313131', 'House 11, G-9, Islamabad',           'Staff Nurse',          78000.00),
(23, 'Bushra',   'Waheed',  'Gillani',   '35301-1414141-4', '1995-07-19', '0322-1414141', 'House 3, Iqbal Town, Lahore',        'Non-Registered Nurse', 55000.00),
(24, 'Maryam',   'Adeel',   'Khattak',   '42201-1515151-5', '1996-05-27', '0323-1515151', 'House 22, Orangi Town, Karachi',     'Non-Registered Nurse', 53000.00),
(25, 'Shazia',   'Arif',    'Bhatti',    '38403-1616161-6', '1994-03-09', '0324-1616161', 'House 8, Chaklala, Rawalpindi',      'Non-Registered Nurse', 54000.00),
(26, 'Shahid',   'Maqsood', 'Rana',      '42101-2727272-7', '1980-08-23', '0326-2727272', 'House 15, Nazimabad, Karachi',       'Admin',                60000.00),
(27, 'Pervez',   'Latif',   'Gul',       '37405-2828282-8', '1978-12-01', '0327-2828282', 'House 6, E-11, Islamabad',           'Lab Tech',             55000.00),
(28, 'Adnan',    'Hamid',   'Warraich',  '35301-2929292-9', '1983-02-15', '0328-2929292', 'House 20, DHA Phase 1, Lahore',      'Lab Tech',             57000.00),
(29, 'Wasim',    'Sajid',   'Paracha',   '42201-3030303-0', '1987-06-28', '0329-3030303', 'Flat 7, Clifton, Karachi',           'Pharmacist',           62000.00),
(30, 'Danish',   'Faisal',  'Lodhi',     '38403-3131313-1', '1990-09-14', '0330-3131313', 'House 12, Cantt, Rawalpindi',        'Pharmacist',           61000.00);
GO


INSERT INTO WARD (wardID, Ward_Name, Speciality_id, Block, Location, Contact_No, Total_Beds, Occupied_Beds, Available_Beds, Floor) VALUES
(1,  'Cardiac Ward',       1,  'A', 'North Wing, Ivor Paine Memorial Hospital',   '051-11110001', 0, 0, 0, 1),
(2,  'Neuro Ward',         2,  'A', 'North Wing, Ivor Paine Memorial Hospital',   '051-11110002', 0, 0, 0, 2),
(3,  'Ortho Ward',         3,  'B', 'South Wing, Ivor Paine Memorial Hospital',   '051-11110003', 0, 0, 0, 1),
(4,  'Children Ward',      4,  'B', 'South Wing, Ivor Paine Memorial Hospital',   '051-11110004', 0, 0, 0, 2),
(5,  'Maternity Ward',     5,  'C', 'East Wing, Ivor Paine Memorial Hospital',    '051-11110005', 0, 0, 0, 1),
(6,  'Skin Ward',          6,  'C', 'East Wing, Ivor Paine Memorial Hospital',    '051-11110006', 0, 0, 0, 2),
(7,  'Oncology Ward',      7,  'D', 'West Wing, Ivor Paine Memorial Hospital',    '051-11110007', 0, 0, 0, 1),
(8,  'GI Ward',            8,  'D', 'West Wing, Ivor Paine Memorial Hospital',    '051-11110008', 0, 0, 0, 2),
(9,  'Respiratory Ward',   9,  'E', 'Central Wing, Ivor Paine Memorial Hospital', '051-11110009', 0, 0, 0, 1),
(10, 'Emergency Ward',    10,  'E', 'Central Wing, Ivor Paine Memorial Hospital', '051-11110010', 0, 0, 0, 0);
GO


INSERT INTO CARE_UNIT (unitID, wardID, UnitName, CostPerDay, Type) VALUES
(1,  1,  'Cardiac ICU',            8000.00, 'ICU'),
(2,  1,  'Cardiac General',        3500.00, 'General'),
(3,  2,  'Neuro ICU',              9000.00, 'ICU'),
(4,  2,  'Neuro General',          4000.00, 'General'),
(5,  3,  'Ortho Surgery Unit',     5000.00, 'Surgery'),
(6,  3,  'Ortho Rehab Unit',       3000.00, 'Rehab'),
(7,  4,  'NICU',                  10000.00, 'ICU'),
(8,  4,  'Pediatric General',      3500.00, 'General'),
(9,  5,  'Labour Unit',            6000.00, 'Labour'),
(10, 5,  'Post-Natal Unit',        4000.00, 'General'),
(11, 7,  'Chemo Unit',             7000.00, 'Chemo'),
(12, 8,  'Endoscopy Unit',         5500.00, 'Procedure'),
(13, 9,  'Ventilator Unit',        9500.00, 'ICU'),
(14, 10, 'Emergency Trauma Unit',  6500.00, 'Emergency'),
(15, 6,  'Derm Procedure Unit',    4500.00, 'Procedure');
GO


INSERT INTO NURSE (NurseID, nurseType, shift, review_date, CareUnitID) VALUES

(11, 'Day Sister',           'Morning',   '2025-06-10', 1),
(12, 'Day Sister',           'Morning',   '2025-06-14', 3),
(13, 'Day Sister',           'Morning',   '2025-06-20', 5),
(14, 'Night Sister',         'Night',     '2025-06-15', 2),
(15, 'Night Sister',         'Night',     '2025-06-10', 4),
(16, 'Night Sister',         'Night',     '2025-06-28', 6),
(17, 'Staff Nurse',          'Morning',   '2025-07-05', 7),
(18, 'Staff Nurse',          'Afternoon', '2025-06-20', 8),
(19, 'Staff Nurse',          'Morning',   '2025-06-15', 9),
(20, 'Staff Nurse',          'Morning',   '2025-07-01', 10),
(21, 'Staff Nurse',          'Afternoon', '2025-06-10', 11),
(22, 'Staff Nurse',          'Night',     '2025-06-25', 12),
(23, 'Non-Registered Nurse', 'Morning',   '2025-06-30', 13),
(24, 'Non-Registered Nurse', 'Afternoon', '2025-07-20', 14),
(25, 'Non-Registered Nurse', 'Night',     '2025-06-08', 15);
GO


INSERT INTO DOCTOR (DoctorID, ConsultantID, position, datejoined, speciality_id, wardID, lead_id) VALUES

(1,  101, 'Consultant',          '2000-06-01', 1,  1,  NULL),  
(2,  102, 'Consultant',          '2002-03-15', 2,  2,  NULL),  
(3,  103, 'Consultant',          '2003-09-01', 3,  3,  NULL),  
(4,  NULL,'Registrar',           '2010-01-20', 1,  1,  1),    
(5,  NULL,'Registrar',           '2011-07-10', 2,  2,  2),    
(6,  NULL,'Assistant Registrar', '2014-11-05', 3,  3,  3),    
(7,  NULL,'Assistant Registrar', '2015-04-22', 1,  1,  1),    
(8,  NULL,'Senior Houseman',     '2018-08-30', 2,  2,  2),    
(9,  NULL,'Senior Houseman',     '2019-02-14', 3,  3,  3),    
(10, NULL,'Junior Houseman',     '2022-12-01', 1,  1,  1),    
(55, NULL,'Junior Houseman',     '2023-03-10', 2,  2,  2),     
(56, NULL,'Student',             '2024-01-15', 1,  1,  1),   
(57, NULL,'Student',             '2024-01-15', 3,  3,  3);     
GO


INSERT INTO PATIENT 
(patientNo, patientName, dateOfBirth, age, dateadmit, location, house, street, zipcode, region, staffID_Nurse) 
VALUES
(1,  'Muhammad Usman',    '1980-04-15', 46, '2025-01-05', 'Lahore',      '12',  'Gulberg Main Blvd',        '54000', 'Punjab',  11),
(2,  'Fatima Zahra',      '1995-08-22', 30, '2025-01-07', 'Karachi',     '5A',  'Clifton Road',             '75600', 'Sindh',   12),
(3,  'Ahmed Raza',        '1972-12-01', 53, '2025-01-10', 'Islamabad',   '3',   'F-8 Markaz',               '44000', 'Punjab',  13),
(4,  'Kiran Bano',        '2000-03-30', 26, '2025-01-12', 'Rawalpindi',  '9',   'Satellite Town',           '46000', 'Punjab',  14),
(5,  'Shahzaib Khan',     '1965-07-19', 60, '2025-01-15', 'Lahore',      '22',  'Model Town Link Rd',       '54700', 'Punjab',  15),
(6,  'Rukhsana Bibi',     '1990-11-05', 35, '2025-01-18', 'Karachi',     '7',   'PECHS Block 2',            '75400', 'Sindh',   16),
(7,  'Faisal Mehmood',    '1985-02-28', 41, '2025-01-20', 'Lahore',      '33',  'DHA Phase 4',              '54810', 'Punjab',  17),
(8,  'Nazia Sultana',     '1978-06-14', 47, '2025-01-22', 'Islamabad',   '6',   'G-10/2',                   '44100', 'Punjab',  18),
(9,  'Umar Farooq',       '2010-09-09', 15, '2025-01-25', 'Peshawar',    '14',  'Hayatabad Phase 3',        '25000', 'KPK',     19),
(10, 'Sadia Perveen',     '1955-01-20', 71, '2025-01-28', 'Lahore',      '1',   'Johar Town Block D',       '54782', 'Punjab',  20),
(11, 'Hamza Tariq',       '1998-05-03', 27, '2025-02-01', 'Karachi',     '18',  'North Nazimabad Block L',  '75850', 'Sindh',   21),
(12, 'Zara Akram',        '1988-10-17', 37, '2025-02-03', 'Lahore',      '4',   'Wapda Town Phase 1',       '54770', 'Punjab',  22),
(13, 'Bilal Hussain',     '1973-03-25', 53, '2025-02-06', 'Multan',      '11',  'Cantt Road',               '60000', 'Punjab',  23),
(14, 'Amira Noor',        '2003-07-11', 22, '2025-02-09', 'Islamabad',   '8',   'E-11/3',                   '44110', 'Punjab',  24),
(15, 'Junaid Akhtar',     '1960-12-31', 65, '2025-02-12', 'Karachi',     '25',  'Gulshan Block 13',         '75300', 'Sindh',   25),
(16, 'Hira Saleem',       '1993-04-08', 33, '2025-02-15', 'Lahore',      '6',   'Iqbal Town Ravi Block',    '54570', 'Punjab',  11),
(17, 'Aamir Shabbir',     '1982-08-23', 43, '2025-02-18', 'Rawalpindi',  '3',   'Chaklala Scheme 3',        '46220', 'Punjab',  12),
(18, 'Sumbal Yaseen',     '1997-01-15', 29, '2025-02-20', 'Quetta',      '19',  'Jinnah Road',              '87300', 'Baloch',  13),
(19, 'Irfan Siddiqui',    '1969-06-02', 56, '2025-02-23', 'Karachi',     '30',  'Malir Halt',               '75080', 'Sindh',   14),
(20, 'Lubna Rafiq',       '1975-09-28', 50, '2025-02-26', 'Lahore',      '2',   'Cantt Racecourse Rd',      '54810', 'Punjab',  15),
(21, 'Mudassar Ali',      '2005-11-14', 20, '2025-03-01', 'Faisalabad',  '7',   'D-Ground',                 '38000', 'Punjab',  16),
(22, 'Shirin Zaidi',      '1950-02-07', 76, '2025-03-04', 'Karachi',     '12',  'Defence Phase 6',          '75500', 'Sindh',   17),
(23, 'Waqar Nazir',       '1987-05-19', 38, '2025-03-07', 'Islamabad',   '5',   'I-10/4',                   '44000', 'Punjab',  18),
(24, 'Naila Bashir',      '1992-08-31', 33, '2025-03-10', 'Lahore',      '16',  'Township Sector B2',       '54600', 'Punjab',  19),
(25, 'Zulfiqar Haider',   '1958-04-22', 68, '2025-03-13', 'Hyderabad',   '9',   'Latifabad Unit 8',         '71000', 'Sindh',   20),
(26, 'Maham Ilyas',       '2001-10-10', 24, '2025-03-16', 'Lahore',      '21',  'Bahria Town Sector C',     '54000', 'Punjab',  21),
(27, 'Asif Nawaz',        '1979-12-05', 46, '2025-03-19', 'Karachi',     '4',   'Korangi Industrial',       '74900', 'Sindh',   22),
(28, 'Robina Kausar',     '1966-03-18', 60, '2025-03-22', 'Rawalpindi',  '8',   'Westridge Colony',         '46100', 'Punjab',  23),
(29, 'Saad Rehman',       '2008-07-27', 17, '2025-03-25', 'Lahore',      '3',   'Allama Iqbal Town',        '54570', 'Punjab',  24),
(30, 'Parveen Akhtar',    '1945-01-01', 81, '2025-03-28', 'Peshawar',    '6',   'University Town',          '25120', 'KPK',     25);
GO


INSERT INTO BED (bedID, unitID, bedType, status) VALUES
(1,  1,  'ICU Bed',       'Available'),
(2,  1,  'ICU Bed',       'Available'),
(3,  2,  'Standard',      'Available'),
(4,  2,  'Standard',      'Available'),
(5,  3,  'ICU Bed',       'Available'),
(6,  3,  'ICU Bed',       'Available'),
(7,  4,  'Standard',      'Available'),
(8,  4,  'Standard',      'Available'),
(9,  5,  'Surgery Bed',   'Available'),
(10, 5,  'Surgery Bed',   'Available'),
(11, 6,  'Rehab Bed',     'Available'),
(12, 7,  'Incubator',     'Available'),
(13, 8,  'Standard',      'Available'),
(14, 9,  'Labour Bed',    'Available'),
(15, 10, 'Post-Natal Bed','Available'),
(16, 11, 'Chemo Chair',   'Available'),
(17, 12, 'Procedure Bed', 'Available'),
(18, 13, 'Ventilator Bed','Available'),
(19, 14, 'Trauma Bed',    'Available'),
(20, 15, 'Standard',      'Available');
GO


INSERT INTO BED_ALLOCATED (bedID, patientNo, duration) VALUES
(1,  1,  5),
(2,  2,  3),
(3,  3,  7),
(4,  4,  2),
(5,  5,  10),
(6,  6,  4),
(7,  7,  6),
(8,  8,  3),
(9,  9,  8),
(10, 10, 14),
(11, 11, 5),
(12, 12, 9),
(13, 13, 2),
(14, 14, 7),
(15, 15, 3),
(16, 16, 11),
(17, 17, 4),
(18, 18, 6),
(19, 19, 2),
(20, 20, 5);
GO


INSERT INTO PERFORMANCE (DoctorID, review_date, grade) VALUES

(4,  '2024-01-15', 'A'),
(4,  '2024-07-15', 'A+'),
(5,  '2024-02-20', 'A'),
(5,  '2024-08-20', 'A+'),
(6,  '2024-03-10', 'B+'),
(6,  '2024-09-10', 'A'),
(7,  '2024-04-05', 'B+'),
(7,  '2024-10-05', 'A'),
(8,  '2024-01-30', 'B'),
(8,  '2024-07-30', 'B+'),
(9,  '2024-05-18', 'B'),
(9,  '2024-11-18', 'B+'),
(10, '2024-02-10', 'C+'),
(10, '2024-08-10', 'B'),
(55, '2024-03-25', 'C'),
(55, '2024-09-25', 'C+'),
(56, '2024-06-01', 'C'),
(57, '2024-06-01', 'C'),
(1,  '2024-12-01', 'A+'),
(2,  '2024-12-01', 'A+');
GO


INSERT INTO EXPERIENCE (expID, DoctorID, establishment, position_held, from_date, to_date, staffID) VALUES

(1,  1, 'Services Hospital Lahore',       'Student',              '1991-01-01', '1993-12-31', 1),
(2,  1, 'Jinnah Hospital Lahore',         'Junior Houseman',      '1994-01-01', '1996-12-31', 1),
(3,  1, 'Mayo Hospital Lahore',           'Senior Houseman',      '1997-01-01', '1998-12-31', 1),
(4,  1, 'Shaukat Khanum Hospital',        'Registrar',            '1999-01-01', '2000-05-31', 1),
(5,  2, 'Aga Khan University Hospital',   'Junior Houseman',      '1995-06-01', '1998-05-31', 2),
(6,  2, 'Liaquat National Hospital',      'Senior Houseman',      '1998-06-01', '2000-05-31', 2),
(7,  2, 'PIMS Islamabad',                 'Assistant Registrar',  '2000-06-01', '2002-03-14', 2),
(8,  3, 'Holy Family Hospital Rwp',       'Junior Houseman',      '1996-01-01', '1998-12-31', 3),
(9,  3, 'Combined Military Hospital',     'Senior Houseman',      '1999-01-01', '2001-12-31', 3),
(10, 3, 'DHQ Hospital Lahore',            'Registrar',            '2002-01-01', '2003-08-31', 3),
(11, 4, 'Services Hospital Lahore',       'Junior Houseman',      '2005-01-01', '2007-06-30', 4),
(12, 4, 'Shaukat Khanum Hospital',        'Senior Houseman',      '2007-07-01', '2009-12-31', 4),
(13, 5, 'Jinnah Hospital Lahore',         'Junior Houseman',      '2006-01-01', '2008-06-30', 5),
(14, 5, 'Aga Khan University Hospital',   'Senior Houseman',      '2008-07-01', '2010-12-31', 5),
(15, 6, 'Mayo Hospital Lahore',           'Junior Houseman',      '2009-01-01', '2011-06-30', 6),
(16, 6, 'DHQ Hospital Lahore',            'Senior Houseman',      '2011-07-01', '2014-10-31', 6),
(17, 7, 'Holy Family Hospital Rwp',       'Junior Houseman',      '2010-01-01', '2012-12-31', 7),
(18, 7, 'Services Hospital Lahore',       'Senior Houseman',      '2013-01-01', '2015-03-31', 7),
(19, 8, 'PIMS Islamabad',                 'Junior Houseman',      '2014-01-01', '2017-12-31', 8),
(20, 9, 'Liaquat National Hospital',      'Junior Houseman',      '2015-01-01', '2018-12-31', 9);
GO


INSERT INTO TREATMENT (treatmentno, treatmentname, description, Type, speciality_id) VALUES
(1,  'Angioplasty',          'Procedure to open blocked coronary arteries',          'Surgical',    1),
(2,  'ECG Monitoring',       'Continuous cardiac electrical activity monitoring',    'Diagnostic',  1),
(3,  'MRI Brain Scan',       'Magnetic resonance imaging of brain tissue',           'Diagnostic',  2),
(4,  'Physiotherapy',        'Physical rehabilitation for neurological conditions',  'Therapeutic', 2),
(5,  'Knee Replacement',     'Surgical replacement of damaged knee joint',           'Surgical',    3),
(6,  'Fracture Management',  'Setting and casting of bone fractures',                'Surgical',    3),
(7,  'Neonatal Care',        'Intensive care for premature or ill newborns',         'Therapeutic', 4),
(8,  'Vaccination',          'Immunization against infectious diseases',             'Preventive',  4),
(9,  'Normal Delivery',      'Natural childbirth assistance and care',               'Obstetric',   5),
(10, 'C-Section',            'Surgical delivery via caesarean section',              'Surgical',    5),
(11, 'Chemotherapy',         'Drug treatment targeting cancer cells',                'Oncological', 7),
(12, 'Endoscopy',            'Internal examination of gastrointestinal tract',       'Diagnostic',  8),
(13, 'Ventilation Therapy',  'Mechanical breathing support for respiratory failure', 'Therapeutic', 9),
(14, 'Trauma Management',    'Emergency care for traumatic injuries',                'Emergency',   10),
(15, 'Skin Biopsy',          'Tissue extraction for skin condition diagnosis',       'Diagnostic',  6);
GO


INSERT INTO COMPLAINT (complaintno, patientNo, staffID_Dr, description, severity, dateReported, location) VALUES
(1,  1,  1,  'Chest pain and shortness of breath on exertion',          'High',     '2025-01-05', 'Cardiac Ward'),
(2,  1,  4,  'Irregular heartbeat episodes at rest',                    'High',     '2025-01-05', 'Cardiac Ward'),
(3,  2,  2,  'Persistent severe headaches lasting over a week',         'Medium',   '2025-01-07', 'Neuro Ward'),
(4,  3,  3,  'Right knee pain and swelling after fall',                 'Medium',   '2025-01-10', 'Ortho Ward'),
(5,  4,  5,  'Recurring migraines with visual disturbances',            'Medium',   '2025-01-12', 'Neuro Ward'),
(6,  5,  1,  'Acute myocardial infarction symptoms',                    'Critical', '2025-01-15', 'Cardiac ICU'),
(7,  6,  3,  'Lower back pain radiating to left leg',                   'Medium',   '2025-01-18', 'Ortho Ward'),
(8,  7,  6,  'Widespread skin rash with itching and redness',           'Low',      '2025-01-20', 'Skin Ward'),
(9,  8,  2,  'Memory loss and confusion episodes',                      'High',     '2025-01-22', 'Neuro Ward'),
(10, 9,  4,  'High fever and respiratory distress',                     'Critical', '2025-01-25', 'Children Ward'),
(11, 10, 1,  'Hypertensive crisis with chest tightness',                'Critical', '2025-01-28', 'Cardiac ICU'),
(12, 11, 7,  'Unexplained weight loss and fatigue',                     'High',     '2025-02-01', 'Oncology Ward'),
(13, 12, 2,  'Numbness in right arm and slurred speech',                'Critical', '2025-02-03', 'Neuro Ward'),
(14, 13, 3,  'Hip fracture from road accident',                         'High',     '2025-02-06', 'Ortho Ward'),
(15, 14, 5,  'Severe nausea, vomiting and abdominal pain',              'Medium',   '2025-02-09', 'GI Ward'),
(16, 15, 4,  'Difficulty breathing and wheezing at night',              'High',     '2025-02-12', 'Respiratory Ward'),
(17, 16, 1,  'Palpitations and dizziness on standing',                  'Medium',   '2025-02-15', 'Cardiac Ward'),
(18, 17, 6,  'Chronic psoriasis flare-up covering 40% body',           'Medium',   '2025-02-18', 'Skin Ward'),
(19, 18, 8,  'Persistent acid reflux and difficulty swallowing',        'Medium',   '2025-02-20', 'GI Ward'),
(20, 19, 1,  'Angina pectoris with radiation to left arm',              'High',     '2025-02-23', 'Cardiac Ward');
GO


INSERT INTO PATIENT_TREATMENT (patientNo, treatmentno, complaintno, DoctorID, duration) VALUES
(1,  2,  1,  1,  5),
(1,  1,  2,  4,  3),
(2,  3,  3,  2,  3),
(3,  6,  4,  3,  7),
(4,  4,  5,  5,  10),
(5,  1,  6,  1,  1),
(6,  4,  7,  6,  14),
(7,  15, 8,  6,  2),
(8,  3,  9,  2,  4),
(9,  7,  10, 4,  8),
(10, 2,  11, 1,  14),
(11, 11, 12, 7,  21),
(12, 3,  13, 2,  5),
(13, 5,  14, 3,  12),
(14, 12, 15, 8,  2),
(15, 13, 16, 9,  7),
(16, 2,  17, 1,  4),
(17, 15, 18, 6,  6),
(18, 12, 19, 8,  3),
(19, 1,  20, 1,  6),
(20, 2,  11, 4,  5),
(5,  2,  6,  7,  4),
(1,  4,  1,  4,  7),
(10, 1,  11, 4,  2),
(13, 6,  14, 9,  10),
(3,  4,  4,  6,  5);
GO





USE HospitalDB_v2;
GO

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
JOIN STAFF  sd ON sd.staffID = d.DoctorID
JOIN PATIENT_TREATMENT pt ON pt.DoctorID = d.DoctorID
JOIN PATIENT p   ON p.patientNo  = pt.patientNo
JOIN NURSE  n    ON n.NurseID    = p.staffID_Nurse
JOIN STAFF  sn   ON sn.staffID   = n.NurseID
JOIN CARE_UNIT cu ON cu.unitID   = n.CareUnitID
WHERE LOWER(d.position) IN ('jh','Junior Houseman','junior house man','j.h.','houseman')
ORDER BY doctor_name, p.patientName;





--for query 4 junior house man
USE HospitalDB_v2;
GO

-- Additional PATIENT_TREATMENT rows for Junior Housemen 


INSERT INTO COMPLAINT (complaintno, patientNo, staffID_Dr, description, severity, dateReported, location) VALUES
(21, 2,  10, 'Dizziness and blurred vision after head injury',   'Medium', '2025-03-01', 'Neuro Ward'),
(22, 6,  10, 'Post-op physiotherapy needed for knee recovery',   'Low',    '2025-03-05', 'Ortho Ward'),
(23, 11, 55, 'Fatigue and nausea during chemotherapy cycle',     'Medium', '2025-03-08', 'Oncology Ward'),
(24, 15, 55, 'Increased breathlessness during physical activity','High',   '2025-03-10', 'Respiratory Ward');
GO

INSERT INTO PATIENT_TREATMENT (patientNo, treatmentno, complaintno, DoctorID, duration) VALUES
(2,  4,  21, 10, 6),
(6,  6,  22, 10, 5),
(11, 13, 23, 55, 14), 
(15, 14, 24, 55, 9);   
GO


USE HospitalDB_v2;
GO



SELECT * FROM PATIENT;
SELECT * FROM STAFF;
SELECT * FROM DOCTOR;
SELECT * FROM NURSE;
SELECT * FROM SPECIALITY;
SELECT * FROM CARE_UNIT;
SELECT * FROM WARD;
SELECT * FROM BED;
SELECT * FROM BED_ALLOCATED;
SELECT * FROM COMPLAINT;
SELECT * FROM TREATMENT;
SELECT * FROM PATIENT_TREATMENT;
SELECT * FROM PERFORMANCE;

