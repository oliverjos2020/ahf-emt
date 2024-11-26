<?php
require_once('dbfunctions.php');
require_once('validateionClass.php');
require_once('accessClass.php');
require_once('validateionClass.php');


class VisitsClass {
    private $db; 
    private $accessToken;
    private $validator; 

    public function __construct() {
        $this->db = new Dbobject(); 
        $this->accessToken = new AccessClass();
        $this->validator = new ValidationClass(); 
        
    }


    public function createUserNumber(){
        $timestamp = round(microtime(true) * 1000);
        $random = mt_rand(1000, 9999);
        $combined = $timestamp . $random;
        $uniqueNumber = substr($combined, -10);
        return $uniqueNumber;
    }

    public function generateVisit() {
        do {
            $idNumber = $this->createUserNumber();
            
            $findIfExists = $this->db->getitemlabel('userdata', 'username', $idNumber, 'username');
        } while ($findIfExists); 

        return $idNumber;
    }


    public function calculateNextVisit($patientId) {
        // Retrieve completed visits for the patient
        $resultCk = $this->db->selectTableData('patient_visit', '*', "status ='Completed' AND patient_id='".$patientId."'", '');
        $count = is_array($resultCk) ? count($resultCk) : 0;
        
        // If there are no completed visits, no next visit can be scheduled
        if ($count == 0) {
            return null;
        }
    
        $nextVisitDate = new DateTime();
    
        switch ($count) {
            case 1:
                // Set next visit 1 month from the current date, on a weekday
                $nextVisitDate->modify('+1 month');
                $this->setToWeekday($nextVisitDate);
                break;
                
            case 2:
                // Set next visit 3 months from the date of the second visit
                $secondVisitDate = new DateTime($resultCk[1]['visit_date']);
                $secondVisitDate->modify('+3 months');
                $this->setToWeekday($secondVisitDate);
                $nextVisitDate = $secondVisitDate;
                break;
                
            case 3:
                // Set next visit 6 months from the date of the third visit
                $thirdVisitDate = new DateTime($resultCk[2]['visit_date']);
                $thirdVisitDate->modify('+6 months');
                $this->setToWeekday($thirdVisitDate);
                $nextVisitDate = $thirdVisitDate;
                break;
                
            case 4:
                // Set next visit 1 year from the date of the fourth visit
                $fourthVisitDate = new DateTime($resultCk[3]['visit_date']);
                $fourthVisitDate->modify('+1 year');
                $this->setToWeekday($fourthVisitDate);
                $nextVisitDate = $fourthVisitDate;
                break;
    
            default:
                // For more than 4 visits, no specific logic; could return null or latest date logic
                return null;
        }
        
        return $nextVisitDate->format('Y-m-d');
    }
    
    // Helper function to ensure the date is on a weekday
    private function setToWeekday(DateTime $date) {
        $dayOfWeek = $date->format('N'); // 1 = Monday, 7 = Sunday
        if ($dayOfWeek > 5) { // If Saturday or Sunday
            $date->modify('next Monday');
        }
    }
    

    public function createVisit($patientId, $postedby, $facilityCode, $call) {
        // Ensure timezone is set correctly
        $userTimeZone = 'UTC'; // Default timezone
        date_default_timezone_set($userTimeZone);

        $resultCk = $this->db->selectTableData('patient_visit', '*', "status ='Ongoing' AND patient_id='".$patientId."'", '');
        $count = is_array($resultCk) ? count($resultCk) : 0;
        // return $count;s
        if ($call != 'inApp') {
            if ($count >= 1) {
                return "This patient is currently on a visit. Kindly cancle previous visit to create a new one.";
            }
        } else {
            if ($count >= 1){
                return "This patient is currently on a visit. Kindly cancle previous visit to create a new one.";
            } 
        }
        $visit_id = $this->generateVisit();
    
        $data = array(  
            "visit_id" => $visit_id,
            "recorded_by" => $postedby,
            "facility_code" => $facilityCode,
            "patient_id" => $patientId,
            "visit_date" => date('Y-m-d H:i:s'),
            "status" => 'Ongoing',
            "next_appointment"=>$this->calculateNextVisit($patientId)
        );
    
        $submit = $this->db->insertTableData('patient_visit', $data);
    
        if ($call != 'inApp') {
            if (!$submit) {
                return "Cannot create visit at the moment, please try again later.";
            } else {
                return 1;
            }
        } else {
            if (!$submit) {
                return "Cannot create visit at the moment, please try again later.";
            } else {
                return 1;
            }
        }
    }
    


}