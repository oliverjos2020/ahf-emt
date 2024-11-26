<?php
require_once('dbfunctions.php');
require_once('validateionClass.php');
require_once('sendMailClass.php');
require_once('accessClass.php');
require_once('visitsClass.php');


class PatientClass {
    private $db; 
    private $validator; 
    private $mailSender; 
    private $checkFacility;
    private $accessToken;
    private $visitsProcess;

    public function __construct() {
        $this->db = new Dbobject(); 
        $this->validator = new ValidationClass(); 
        $this->mailSender = new SendEmail(); 
        $this->checkFacility = new FacilitiesClass(); 
        $this->accessToken = new AccessClass(); 
        $this->visitsProcess = new VisitsClass(); 
    }



            private function isValidDate($date) {
                return (bool)strtotime($date);
            }
    
            // Dynamic filter function to build condition string
            private function dynamicFilter($userData) {
                $conditions = [];
                
                // Default date range for the current year
                $currentYear = date("Y");
                $defaultStartDate = "$currentYear-01-01";
                $defaultEndDate = "$currentYear-12-31";
                
                // Validate and set start and end dates
                $startDate = (!empty($userData['startDate']) && $this->isValidDate($userData['startDate'])) ? $userData['startDate'] : $defaultStartDate;
                $endDate = (!empty($userData['endDate']) && $this->isValidDate($userData['endDate'])) ? $userData['endDate'] : $defaultEndDate;
                
                // Date range condition
                $conditions[] = "created BETWEEN '$startDate' AND '$endDate'";
                
                // SearchBy and SearchByValue filtering
                if (!empty($userData['searchBy']) && !empty($userData['searchByValue'])) {
                    $searchBy = $userData['searchBy'];
                    $searchByValue = $userData['searchByValue'];
                    $conditions[] = "$searchBy LIKE '%$searchByValue%'";
                }
                
                // Return the combined condition string
                return implode(" AND ", $conditions);
            }


            public function createUserNumber(){
                $timestamp = round(microtime(true) * 1000);
                $random = mt_rand(1000, 9999);
                $combined = $timestamp . $random;
                $uniqueNumber = substr($combined, -10);
                return $uniqueNumber;
            }

            public function jsonResponse($message = "", $code = "", $data = "") {
                // Create the response array
                $responseArray = [
                    'status' => $code,
                    'message' => $message,
                    'data' => $data
                ];
                
                // Return the JSON-encoded response
                return $responseArray;
            }

            public function generateUserId() {
                do {
                    $idNumber = $this->createUserNumber();
                    
                    $findIfExists = $this->db->getitemlabel('userdata', 'username', $idNumber, 'username');
                } while ($findIfExists); 

                return $idNumber;
            }

            function mapRequestData($requestData) {
                // Mapping request data to database fields
                $mapping = [
                    'fname' => 'fname',            // First name
                    'lname' => 'lname',            // Last name
                    'oname' => 'othern',           // Other name
                    'phone' => 'phone',            // Phone number
                    'dob' => 'dob',                // Date of birth
                    'address' => 'address',        // Address
                    'sex' => 'sex',                // Sex (M/F)
                    'maritalStatus' => 'maritalStatus',  // Marital status (Single, Married, etc.)
                    'nextOfKin' => 'next_of_kin',  // Next of kin name
                    'nextOfKinPhone' => 'nextOfKinPhone', // Next of kin phone number
                    'nextOfKinRel' => 'relationship', // Next of kin relationship
                    'email' => 'email' // Next of kin relationship
                ];
                
                $data = [];
                foreach ($requestData as $key => $value) {
                    if (isset($mapping[$key])) {
                        // Map the request data to the correct database column name
                        $data[$mapping[$key]] = $value;
                    }
                }
                
                return $data;
            }


            public function patientManager($userData) {

                $checkTime = $this->accessToken->checkLoginTime($userData);

                if($checkTime === 1){
                return   $this->accessToken->jsonResponse("Cannot proceed login expired. Kindly logout and login again.", 400, "");
                }

                if($checkTime === 0){
                    return     $this->accessToken->jsonResponse("Access denied !", 403, "");
                }


                if($checkTime === 2){
                    return   $this->accessToken->jsonResponse("Access denied ! Facility credentials not allowed.", 403, "");
                }

            
                $resultCk = $this->db->selectTableData('patient_data', '*', "email='".$userData['email']."'", '');
                if($resultCk){
                    return   $this->accessToken->jsonResponse("Email already used by another patient.", 400, "");  
                }

                $resultCkP = $this->db->selectTableData('patient_data', '*', "phone ='".$userData['phone']."'", '');
                if($resultCkP){
                    return   $this->accessToken->jsonResponse("Phone number already used by another patient.", 400, "");  
                }

                $validate = $this->validator->validate(
                    $userData,
                    array(
                    'fname' => 'required',
                    'lname' => 'required',
                    'phone' => 'required',
                    'sex' => 'required',
                    'dob' => 'required',
                    'maritalStatus'=>'required',
                    'nextOfKin'=>'required',
                    'nextOfKinPhone'=>'required',
                    'nextOfKinRel'=>'required'
                    ),
                    array(
                    'fname' => 'First name',
                    'lname' => 'Last name',
                    'phone' => 'Phone',
                    'sex' => 'Sex',
                    'dob' => 'Date of birth',
                    'maritalStatus'=>'Marital Status',
                    'nextOfKin'=>'Next of kin name',
                    'nextOfKinPhone'=>'Next of kin phone number',
                    'nextOfKinRel'=>'Next of kin relationship'
                    )
                );

                if($validate['error'])
                {
                    return $this->accessToken->jsonResponse($validate['messages'][0], 404,"");
                }

            
                $username = $this->generateUserId();
                $nameValidation = $this->validator->validateSingleName($userData['fname']);
                if ($nameValidation !== true) {
                    return $nameValidation; 
                }
            
                $nameValidation = $this->validator->validateSingleName($userData['lname']);
                if ($nameValidation !== true) {
                    return $nameValidation; 
                }
            
                $emailValidation = $this->validator->validateEmail($userData['email']);
                if ($emailValidation !== true) {
                    return $emailValidation;
                }
            
                $phoneValidation = $this->validator->validatePhoneNumber($userData['phone']);
                if ($phoneValidation !== true) {
                    return $phoneValidation;
                }

                $openToken =  $this->accessToken->getAccessData($userData['token']);
                    
                if($openToken === false){
                    return $this->accessToken->jsonResponse("Invalid facility code!", 401, "");
                }else{
                $facilityCode = $openToken['data']['facilityCode'];
                $postedby = $openToken['data']['username'];
                $source = $openToken['data']['source'];
                }

                        // return $this->jsonResponse($openToken, 400, "");
                if (!empty($userData['operation'])) {

                    switch ($userData['operation']) {
                        case 'new':
                            $patientId = $this->generateUserId();
                            
                            $data = $this->mapRequestData($userData);
                            $data['record_by'] = $postedby;
                            $data['facility_code'] = $facilityCode;
                            $data['source'] = $source ;
                            $data['patient_id'] = $patientId  ;

                            $submit = $this->db->insertTableData('patient_data', $data) ;
                            // var_dump($data);     
                            if(!$submit){
                                return    $this->accessToken->jsonResponse("Cannot process at the moment.", 400, "");
                            }else{
                                $call ='inApp';
                                $setupVisit = $this->visitsProcess->createVisit($patientId , $postedby, $facilityCode, $call);
                                // var_dump($setupVisit);
                                if($setupVisit === 1){
                                    return   $this->accessToken->jsonResponse("Patient created successfully and new visit initiated.", 200, "");
                                }else{
                                    return   $this->accessToken->jsonResponse("Patient profile created successfully But-". $setupVisit, 200, "");
                                }
                            
                            }
                            
                            break;
                
                        case 'edit':
                            $conditions = [
                                'id' => $userData['item_id'] // This uniquely identifies the facility to update
                            ];

                            $data = $this->mapRequestData($userData);
                        
                        
                            $data['updated_by'] = json_encode(array('edited_by'=>$postedby,'source'=>$source,'facility'=>$facilityCode,'date'=>date('Y-m-d H:i:s'))) ;

                            $submit = $this->db->updateTableData('patient_data', $data, $conditions);

                            if(!$submit){
                                return $this->accessToken->jsonResponse("Cannot process at the moment.", 400, "");
                            }else{
                                return $this->accessToken->jsonResponse("User updated successfully!", 200, "");
                            }


                            break;
                
                        default:
                            
                            return $this->accessToken->jsonResponse("Invalid Operation!", 400, "");
                    }
                } else {
                    // Throw error if operation is empty
                    return $this->accessToken->jsonResponse("Operation field required!", 400, "");
                }
                
            
            
            }

            public function getPatientData($userData) { 
                    // Fetch token data
                    $openToken = $this->accessToken->getAccessData($userData['token']);
                    
                    if ($openToken === false) {
                        return $this->accessToken->jsonResponse("Invalid facility code!", 401, "");
                    } else {
                        $facilityCode = $openToken['data']['facilityCode'];
                        $postedby = $openToken['data']['username'];
                        $source = $openToken['data']['source'];
                    }
                
                    // Apply default limit if not set in $userData
                    $limit = !empty($userData['limit']) ? (int)$userData['limit'] : 50;
                    
                    // Get condition string from dynamicFilter
                    $conditionStr = $this->dynamicFilter($userData);
                    if($openToken['data']['role_id'] !== 001){
                    $conditionStr .= " AND facility_code = '$facilityCode'";
                    }else{
                        $conditionStr .= " ";  
                    }
                    // Fetch data from the table with limit
                    $table = 'patient_data'; // Replace with your actual table name


                    $columns = "id, patient_id, fname, lname, othern, occupation, created, education, maritalStatus, address, phone, dob, next_of_kin, relationship, sex, hivConfirmed, priorArt, careentry, testMode, transferredIn, transferredFrom, nextOfKinPhone, age, mothersId, discontinued, is_alive, lost_for_follow_up, record_by, record_date, email";


                    $resultData = $this->db->selectTableData($table, $columns, $conditionStr, $limit);
                    if(!$resultData){
                        return $this->accessToken->jsonResponse("Could not retrieve data !", 404, "");
                    }else{
                        return $this->accessToken->jsonResponse("Data retrived.", 200, $resultData);
                    }
                    // return $resultData; 404
                    
            }
        
            public function setupNewVisit($userData){

                $patient_id = $userData['patient_id'];
                $token = $userData['token'];

                $validate = $this->validator->validate(
                    $userData,
                    array('patient_id' => 'required', 'token' => 'required'),
                    array('patient_id' => 'Patient ID', 'token' => 'Access token')
                );

                if($validate['error'])
                {
                    return $this->accessToken->jsonResponse($validate['messages'][0], 404,"");
                }

                $checkTime = $this->accessToken->checkLoginTime($userData);

                if($checkTime === 1){
                    return   $this->accessToken->jsonResponse("Cannot proceed login expired. Kindly logout and login again.", 400, "");
                }

                if($checkTime === 0){
                    return   $this->accessToken->jsonResponse("Access denied !", 403, "");
                }


                if($checkTime === 2){
                    return   $this->accessToken->jsonResponse("Access denied ! Facility credentials not allowed.", 403, "");
                }


                $resultCk = $this->db->selectTableData('patient_data', '*', "patient_id='".$userData['patient_id']."'", '');
                if(!$resultCk){
                    return   $this->accessToken->jsonResponse("Invalid patient ID", 400, "");  
                }

                $openToken =  $this->accessToken->getAccessData($userData['token']);
                        
                if($openToken === false){
                    return $this->accessToken->jsonResponse("Invalid facility code!", 401, "");
                }else{
                    $facilityCode = $openToken['data']['facilityCode'];
                    $postedby = $openToken['data']['username'];
                    $source = $openToken['data']['source'];
                }

                    $call ='';
                    $setupVisit = $this->visitsProcess->createVisit($userData['patient_id'] , $postedby, $facilityCode, $call);
                         // var_dump($setupVisit);
                    if($setupVisit === 1){
                        return   $this->accessToken->jsonResponse("New visit initiated.", 200, "");
                    }else{
                        return   $this->accessToken->jsonResponse( $setupVisit, 200, "");
                    }

            }
            

                // Optional: close database connection
                public function closeConnection() {
                    $this->db->closeConnection();
                }
}
