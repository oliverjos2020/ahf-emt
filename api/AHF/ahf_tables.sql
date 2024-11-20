-- .drug_category definition

CREATE TABLE `drug_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- .drug_inventory_history definition

CREATE TABLE `drug_inventory_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `quantity_diff` decimal(10,2) DEFAULT 0.00,
  `quantity_current` decimal(10,2) DEFAULT 0.00,
  `quantity_before` decimal(10,2) DEFAULT 0.00,
  `batch_number` varchar(50) DEFAULT NULL,
  `record_by` varchar(255) NOT NULL,
  `record_date` datetime NOT NULL DEFAULT current_timestamp(),
  `facility_code` varchar(50) NOT NULL,
  `dispensed_to` varchar(100) DEFAULT NULL,
  `action` enum('dispensed','added_to') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- .hospital_facilities definition

CREATE TABLE `hospital_facilities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facility_code` varchar(50) NOT NULL,
  `hospital_name` varchar(100) NOT NULL DEFAULT 'AHF',
  `address` varchar(255) NOT NULL,
  `contact_officer` varchar(100) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `suspended_status` tinyint(1) DEFAULT 0,
  `web_access` tinyint(1) DEFAULT 0,
  `action_by` varchar(100) DEFAULT NULL,
  `edited_by` varchar(100) DEFAULT NULL,
  `edited_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- .`parameter` definition

CREATE TABLE `parameter` (
  `parameter_name` varchar(50) DEFAULT NULL,
  `parameter_value` varchar(100) DEFAULT NULL,
  `privilege_flag` char(1) DEFAULT NULL,
  `parameter_description` varchar(150) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- patient_care_entry definition

CREATE TABLE `patient_care_entry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `point` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- patient_data definition

CREATE TABLE `patient_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(50) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `othern` varchar(100) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `education` varchar(100) DEFAULT NULL,
  `maritalStatus` enum('Single','Married','Divorced','Widowed') NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `next_of_kin` varchar(100) DEFAULT NULL,
  `relationship` varchar(50) DEFAULT NULL,
  `sex` enum('M','F') NOT NULL,
  `hivConfirmed` date DEFAULT NULL,
  `priorArt` varchar(100) DEFAULT NULL,
  `careentry` varchar(100) DEFAULT NULL,
  `testMode` varchar(100) DEFAULT NULL,
  `transferredIn` date DEFAULT NULL,
  `transferredFrom` varchar(100) DEFAULT NULL,
  `nextOfKinPhone` varchar(15) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `mothersId` varchar(50) DEFAULT NULL,
  `discontinued` tinyint(1) DEFAULT 0,
  `is_alive` tinyint(1) DEFAULT 1,
  `lost_for_follow_up` tinyint(1) DEFAULT 0,
  `record_by` varchar(255) NOT NULL,
  `record_date` datetime DEFAULT NULL,
  `facility_code` varchar(50) DEFAULT NULL,
  `source` varchar(20) DEFAULT NULL,
  `push_flag` int(11) DEFAULT 0,
  `updated_by` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- patient_lab definition

CREATE TABLE `patient_lab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visit_id` varchar(255) NOT NULL,
  `visit_date` datetime DEFAULT NULL,
  `tb_status` enum('no signs','presumptive tb','on tpt','confirmed tb') NOT NULL,
  `tb_details` text DEFAULT NULL,
  `cryptococcal_status` enum('not screened','screened for cryptoccus Ag','Cr Ag negative','Cr Ag positive','Cr Ag positive commenced on pre-emptive','Diagnosed with Cryptococcal meningitis','commenced treatment for cryptococcal meningitis') NOT NULL,
  `cervical_cancer_status` enum('not ordered','ordered yet to screen','screened negative','screened positive yet to treat','screened positive and treated','screened positive and referred','screened positive declined treatment','suspicious for cancer') NOT NULL,
  `cancer_others` text DEFAULT NULL,
  `hepatitis_screening` enum('hepatitis B -ve','hepatitis B +ve','hepatitis C -ve','hepatitis C +ve') DEFAULT NULL,
  `others_ols` text DEFAULT NULL,
  `noted_side_effects` text DEFAULT NULL,
  `DSD_status` enum('Devolved','non-devolved') NOT NULL,
  `DSD_model` varchar(255) DEFAULT NULL,
  `DSD_startdate` date DEFAULT NULL,
  `record_by` varchar(255) NOT NULL,
  `record_date` datetime DEFAULT NULL,
  `patient_id` varchar(50) NOT NULL,
  `facility_code` varchar(50) DEFAULT NULL,
  `push_flag` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- patient_prior_art definition

CREATE TABLE `patient_prior_art` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prior_art` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- patient_side_effects definition

CREATE TABLE `patient_side_effects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `side_effects` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




-- patient_treatment definition

CREATE TABLE `patient_treatment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visit_id` varchar(255) NOT NULL,
  `visit_date` datetime DEFAULT NULL,
  `avr_drugs_regimen` varchar(255) NOT NULL,
  `avr_adherance` enum('1','0') NOT NULL,
  `cotrimoxazole_dose` varchar(50) NOT NULL,
  `cotrimoxazole_adherance` enum('1','0') NOT NULL,
  `tb_medication` varchar(255) DEFAULT NULL,
  `tb_dose` varchar(50) DEFAULT NULL,
  `tb_therapy_adherance` enum('1','0') NOT NULL,
  `other_drugs` text DEFAULT NULL,
  `cd4_ordered` enum('1','0') NOT NULL,
  `cd4_result` int(11) DEFAULT NULL,
  `vl_e27a` decimal(10,2) DEFAULT NULL,
  `vl_e27b` decimal(10,2) DEFAULT NULL,
  `vl_e27c` decimal(10,2) DEFAULT NULL,
  `other_tests` text DEFAULT NULL,
  `record_by` varchar(255) NOT NULL,
  `record_date` datetime DEFAULT NULL,
  `patient_id` varchar(50) NOT NULL,
  `facility_code` varchar(50) DEFAULT NULL,
  `push_flag` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- patient_visit definition

CREATE TABLE `patient_visit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(50) NOT NULL,
  `visit_id` varchar(50) NOT NULL,
  `visit_date` datetime DEFAULT NULL,
  `next_appointment` datetime DEFAULT NULL,
  `status` enum('Ongoing','Completed','Cancelled') NOT NULL,
  `recorded_by` varchar(255) NOT NULL,
  `facility_code` varchar(50) DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  `push_flag` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- patient_vitals definition

CREATE TABLE `patient_vitals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visit_id` varchar(255) NOT NULL,
  `visit_date` date NOT NULL,
  `duration_on_art` int(11) NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  `height` decimal(5,2) NOT NULL,
  `mbi_MUAC` decimal(5,2) NOT NULL,
  `bp` varchar(10) NOT NULL,
  `pregnancy_status` enum('P','breastfeeding') DEFAULT NULL,
  `EDD` datetime DEFAULT NULL,
  `fp` enum('FP','NO_FP') DEFAULT NULL,
  `fp_type` enum('condoms','oral contraceptive pills','injectable','implantable hormones','Diaphragm/cervical cap','intrauterine device','vasectomy/tubal') DEFAULT NULL,
  `functional_status` enum('working','ambulant','bedridden') NOT NULL,
  `record_by` varchar(255) NOT NULL,
  `record_date` datetime DEFAULT NULL,
  `patient_id` varchar(50) NOT NULL,
  `facility_code` varchar(50) DEFAULT NULL,
  `push_flag` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- regimen_drugs_code definition

CREATE TABLE `regimen_drugs_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `drug` varchar(50) DEFAULT NULL,
  `regimen_code` varchar(10) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- regimens definition

CREATE TABLE `regimens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) DEFAULT NULL,
  `regimen_line` varchar(100) NOT NULL,
  `regimen` varchar(100) NOT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `age_group` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- .viral_load_management definition

CREATE TABLE `viral_load_management` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(50) NOT NULL,
  `visit_id` varchar(255) NOT NULL,
  `test_date` datetime DEFAULT NULL,
  `vl_count` decimal(10,2) NOT NULL,
  `vl_status` enum('Undetectable','Detectable','Not Tested') NOT NULL,
  `notes` text DEFAULT NULL,
  `recorded_by` datetime DEFAULT NULL,
  `recorded_date` date NOT NULL,
  `facility_code` varchar(50) DEFAULT NULL,
  `push_flag` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- .drug_inventory definition

CREATE TABLE `drug_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` decimal(10,2) DEFAULT 0.00,
  `quantity_before` decimal(10,2) DEFAULT 0.00,
  `batch_number` varchar(50) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `supplier` varchar(255) DEFAULT NULL,
  `minimum_stock_level` decimal(10,2) DEFAULT 10.00,
  `status` varchar(50) DEFAULT 'active',
  `record_by` varchar(255) NOT NULL,
  `record_date` datetime NOT NULL DEFAULT current_timestamp(),
  `last_updated_by` varchar(255) DEFAULT NULL,
  `last_updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `facility_code` varchar(50) NOT NULL,
  `recieved_from` varchar(100) DEFAULT NULL,
  `DeliveryNote` varchar(100) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `drug_inventory_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `drug_category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO drug_category (category_name,description) VALUES
	 ('Analgesics','Drugs that relieve pain'),
	 ('Antibiotics','Drugs used to treat bacterial infections'),
	 ('Antivirals','Drugs used to treat viral infections'),
	 ('Antifungals','Drugs that treat fungal infections'),
	 ('Antiparasitics','Drugs that treat parasitic infections'),
	 ('Anti-inflammatory','Drugs that reduce inflammation'),
	 ('Antipyretics','Drugs that reduce fever'),
	 ('Antihistamines','Drugs that treat allergic reactions'),
	 ('Anticoagulants','Drugs that prevent blood clotting'),
	 ('Antidepressants','Drugs that treat depression');
INSERT INTO drug_category (category_name,description) VALUES
	 ('Antipsychotics','Drugs used for mental health conditions like schizophrenia'),
	 ('Anticonvulsants','Drugs that prevent or reduce seizures'),
	 ('Bronchodilators','Drugs that help open airways in respiratory conditions like asthma'),
	 ('Diuretics','Drugs that help reduce excess water in the body'),
	 ('Sedatives','Drugs that promote calm or sleep'),
	 ('Hypnotics','Drugs used to induce and maintain sleep'),
	 ('Muscle Relaxants','Drugs that relieve muscle spasms'),
	 ('Vasodilators','Drugs that widen blood vessels to improve blood flow'),
	 ('Antiemetics','Drugs that prevent or reduce nausea and vomiting'),
	 ('Antidiarrheals','Drugs used to reduce diarrhea');
INSERT INTO drug_category (category_name,description) VALUES
	 ('Antacids','Drugs that neutralize stomach acid'),
	 ('Laxatives','Drugs that relieve constipation'),
	 ('Corticosteroids','Drugs that reduce inflammation and suppress the immune system'),
	 ('Vaccines','Drugs used to stimulate the immune system to prevent diseases'),
	 ('Hormones','Drugs that regulate or replace hormones in the body'),
	 ('Antihypertensives','Drugs used to manage high blood pressure'),
	 ('Antidiabetics','Drugs used to control blood sugar levels'),
	 ('Lipid-lowering Agents','Drugs that reduce cholesterol levels'),
	 ('Contraceptives','Drugs used to prevent pregnancy'),
	 ('Ophthalmic Agents','Drugs used for eye conditions');
INSERT INTO drug_category (category_name,description) VALUES
	 ('Topical Agents','Drugs applied directly to the skin'),
	 ('Immunosuppressants','Drugs that suppress the immune system'),
	 ('Chemotherapeutic Agents','Drugs used to treat cancer'),
	 ('Nucleoside Reverse Transcriptase Inhibitors (NRTIs)','HIV drugs that block reverse transcriptase'),
	 ('Non-Nucleoside Reverse Transcriptase Inhibitors (NNRTIs)','HIV drugs that bind to reverse transcriptase and inhibit its action'),
	 ('Protease Inhibitors (PIs)','HIV drugs that inhibit protease, preventing viral replication'),
	 ('Integrase Strand Transfer Inhibitors (INSTIs)','HIV drugs that block HIV integrase'),
	 ('CCR5 Antagonists (Entry Inhibitors)','HIV drugs that block the CCR5 receptor on the host cell'),
	 ('Fusion Inhibitors','HIV drugs that prevent the virus from fusing with the host cell'),
	 ('Pharmacokinetic Enhancers (Boosters)','Drugs that boost the effectiveness of other ARVs');
INSERT INTO drug_category (category_name,description) VALUES
	 ('Post-Attachment Inhibitors','HIV drugs that prevent the virus from attaching to the host cell'),
	 ('Monoclonal Antibodies','Antibodies designed to target HIV'),
	 ('Combination ARV Therapy (cART)','ARV drugs combining two or more antiretrovirals in one pill');





INSERT INTO `parameter` (parameter_name,parameter_value,privilege_flag,parameter_description,created) VALUES
	 ('ENCRYPTION_KEY','8iJksm0PloDfb15Wasq','1','KEY','2024-10-17 14:33:28');





   INSERT INTO regimen_drugs_code (drug,regimen_code,created) VALUES
	 ('TDF','1a','2024-10-14 09:24:14'),
	 ('TDF','1b','2024-10-14 09:24:14'),
	 ('TDF','1c','2024-10-14 09:24:14'),
	 ('TDF','2b','2024-10-14 09:24:14'),
	 ('TDF','2c','2024-10-14 09:24:14'),
	 ('TDF','2e','2024-10-14 09:24:14'),
	 ('TDF','2f','2024-10-14 09:24:14'),
	 ('TDF','2g','2024-10-14 09:24:14'),
	 ('TDF','4a','2024-10-14 09:24:14'),
	 ('TDF','4d','2024-10-14 09:24:14');
INSERT INTO regimen_drugs_code (drug,regimen_code,created) VALUES
	 ('TDF','5c','2024-10-14 09:24:14'),
	 ('TDF','5d','2024-10-14 09:24:14'),
	 ('3TC','1a','2024-10-14 09:24:14'),
	 ('3TC','1b','2024-10-14 09:24:14'),
	 ('3TC','1c','2024-10-14 09:24:14'),
	 ('3TC','2a','2024-10-14 09:24:14'),
	 ('3TC','2b','2024-10-14 09:24:14'),
	 ('3TC','2c','2024-10-14 09:24:14'),
	 ('3TC','2d','2024-10-14 09:24:14'),
	 ('3TC','2e','2024-10-14 09:24:14');
INSERT INTO regimen_drugs_code (drug,regimen_code,created) VALUES
	 ('3TC','2f','2024-10-14 09:24:14'),
	 ('3TC','2g','2024-10-14 09:24:14'),
	 ('3TC','4a','2024-10-14 09:24:14'),
	 ('3TC','4b','2024-10-14 09:24:14'),
	 ('3TC','4c','2024-10-14 09:24:14'),
	 ('3TC','4d','2024-10-14 09:24:14'),
	 ('3TC','4e','2024-10-14 09:24:14'),
	 ('3TC','4f','2024-10-14 09:24:14'),
	 ('3TC','4g','2024-10-14 09:24:14'),
	 ('3TC','4h','2024-10-14 09:24:14');
INSERT INTO regimen_drugs_code (drug,regimen_code,created) VALUES
	 ('3TC','5a','2024-10-14 09:24:14'),
	 ('3TC','5b','2024-10-14 09:24:14'),
	 ('3TC','5c','2024-10-14 09:24:14'),
	 ('3TC','5d','2024-10-14 09:24:14'),
	 ('3TC','5e','2024-10-14 09:24:14'),
	 ('3TC','5f','2024-10-14 09:24:14'),
	 ('3TC','5g','2024-10-14 09:24:14'),
	 ('3TC','5h','2024-10-14 09:24:14'),
	 ('FTC','1a','2024-10-14 09:24:14'),
	 ('FTC','1b','2024-10-14 09:24:14');
INSERT INTO regimen_drugs_code (drug,regimen_code,created) VALUES
	 ('FTC','1c','2024-10-14 09:24:14'),
	 ('FTC','4a','2024-10-14 09:24:14'),
	 ('FTC','4b','2024-10-14 09:24:14'),
	 ('FTC','4f','2024-10-14 09:24:14'),
	 ('DTG','1a','2024-10-14 09:24:14'),
	 ('DTG','2g','2024-10-14 09:24:14'),
	 ('DTG','3a','2024-10-14 09:24:14'),
	 ('DTG','4a','2024-10-14 09:24:14'),
	 ('DTG','4b','2024-10-14 09:24:14'),
	 ('DTG','5e','2024-10-14 09:24:14');
INSERT INTO regimen_drugs_code (drug,regimen_code,created) VALUES
	 ('DTG','5f','2024-10-14 09:24:14'),
	 ('DTG','6a','2024-10-14 09:24:14'),
	 ('EFV','1b','2024-10-14 09:24:14'),
	 ('EFV','1c','2024-10-14 09:24:14'),
	 ('EFV','4d','2024-10-14 09:24:14'),
	 ('EFV','4h','2024-10-14 09:24:14'),
	 ('EFV400','4d','2024-10-14 09:48:45'),
	 ('EFV400','4f','2024-10-14 09:48:45'),
	 ('AZT','2a','2024-10-14 09:29:11'),
	 ('AZT','2d','2024-10-14 09:29:11');
INSERT INTO regimen_drugs_code (drug,regimen_code,created) VALUES
	 ('AZT','2e','2024-10-14 09:29:11'),
	 ('AZT','2f','2024-10-14 09:29:11'),
	 ('AZT','4e','2024-10-14 09:29:11'),
	 ('AZT','4g','2024-10-14 09:29:11'),
	 ('AZT','5a','2024-10-14 09:29:11'),
	 ('AZT','5b','2024-10-14 09:29:11'),
	 ('AZT','5e','2024-10-14 09:29:11'),
	 ('AZT','5g','2024-10-14 09:29:11'),
	 ('LPV/r','2c','2024-10-14 09:29:11'),
	 ('LPV/r','2d','2024-10-14 09:29:11');
INSERT INTO regimen_drugs_code (drug,regimen_code,created) VALUES
	 ('LPV/r','2f','2024-10-14 09:29:11'),
	 ('LPV/r','4c','2024-10-14 09:29:11'),
	 ('LPV/r','4e','2024-10-14 09:29:11'),
	 ('LPV/r','5a','2024-10-14 09:29:11'),
	 ('LPV/r','5d','2024-10-14 09:29:11'),
	 ('LPV/r','5g','2024-10-14 09:29:11'),
	 ('LPV/r','5h','2024-10-14 09:29:11'),
	 ('ATV/r','2a','2024-10-14 09:29:11'),
	 ('ATV/r','2b','2024-10-14 09:29:11'),
	 ('ATV/r','5b','2024-10-14 09:29:11');
INSERT INTO regimen_drugs_code (drug,regimen_code,created) VALUES
	 ('ATV/r','5c','2024-10-14 09:29:11'),
	 ('RAL','4g','2024-10-14 09:55:55'),
	 ('RAL','5e','2024-10-14 09:55:55'),
	 ('RAL','6a','2024-10-14 09:55:55'),
	 ('ABC','4b','2024-10-14 09:48:45'),
	 ('ABC','4c','2024-10-14 09:48:45'),
	 ('NVP','4h','2024-10-14 09:55:55');




   INSERT INTO patient_side_effects (side_effects) VALUES
	 ('Nausea/Vomiting'),
	 ('Headache'),
	 ('Insomnia/bad dreams'),
	 ('Fatigue/weakness'),
	 ('PV bleeding/discharge'),
	 ('Rash'),
	 ('FAT Changes'),
	 ('Anemia'),
	 ('Drainage of Liquor'),
	 ('Stevens Johnson Syndrome');
INSERT INTO patient_side_effects (side_effects) VALUES
	 ('Hyperglycemia');


   INSERT INTO patient_prior_art (prior_art) VALUES
	 ('Transfer in with records'),
	 ('Transfer in without records'),
	 ('PMTCT only'),
	 ('PEP');


   INSERT INTO patient_care_entry (`point`) VALUES
	 ('OPD-1'),
	 ('In patients-2'),
	 ('HTS-3'),
	 ('TB DOTS-4'),
	 ('STI clinic-5'),
	 ('ANC/PMTCT-6'),
	 ('transfer-in-7');




