<?php
require_once('dbfunctions.php');
require_once('validateionClass.php');
require_once('sendMailClass.php');
require_once('accessClass.php');


class FacilitiesClass {
    private $db; 
    private $validator; 
    private $mailSender; 
    private $accessToken; 

    public function __construct() {
        $this->db = new Dbobject(); 
        $this->validator = new ValidationClass(); 
        $this->mailSender = new SendEmail(); 
        $this->accessToken = new AccessClass();
        
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




    public function createFacilityNumber() {
        do {
            $timestamp = round(microtime(true) * 1000);
            $random = mt_rand(100000, 999999);
            $combined = $timestamp . $random;
            $uniqueNumber = substr($combined, -10);
            $facilityCheck = $this->db->getitemlabel('hospital_facilities', 'facility_code', $uniqueNumber, '*');
        } while ($facilityCheck);  
        return $uniqueNumber;  
    }
    




    public function validateFacility($facilityCode){
        if(empty($facilityCode)){
            return $this->accessToken->jsonResponse("Facility code required!", 400, "");
            exit;
        }
       $facilityCheck =  $this->db->getitemlabel('hospital_facilities', 'facility_code', $facilityCode, '*');
       if(!$facilityCheck){
        return $this->accessToken->jsonResponse("Invalid facility code!", 401, "");
       }else{
        return $this->accessToken->jsonResponse("Valid facility", 200, $facilityCheck);
       }
    }


    function mapRequestData($requestData) {
        $mapping = [
            'facilityName' => 'hospital_name',
            'faclilityAddress' => 'address', 
            'contactNumber' => 'facility_code',
            'contactOfficer' => 'contact_officer',
            'webAccess' => 'web_access',
            'suspendedStatus' => 'suspended_status',
        ];
        $data = [];
        foreach ($requestData as $key => $value) {
            if (isset($mapping[$key])) {
                // Use the mapped column name
                $data[$mapping[$key]] = $value;
            }
        }
        return $data;
    }
    


    public function facilitySetup($userData){
        if($userData['source'] != 'web'){
            return $this->accessToken->jsonResponse("Your device is not allowed to access this portal.", 403,"");
            exit;
      }
       
                $validate = $this->validator->validate(
                    $userData,
                    array('operation'=>'required','facilityName' => 'required', 'faclilityAddress' => 'required', 'contactOfficer'=> 'required', 'contactNumber'=>'required', 'webAccess' =>'required' ),
                    array('operation'=>'operation','facilityName' => 'facilityName', 'faclilityAddress' => 'faclilityAddress', 'contactOfficer'=>'contactOfficer', 'contactNumber'=>'contactNumber', 'webAccess'=>'webAccess')
                );
                if($validate['error'])
                {
                    return $this->accessToken->jsonResponse($validate['messages'][0] , 404,"");
                }
            
                $checkTime = $this->accessToken->checkLoginTime($userData);

                if($checkTime === 1){
                    return $this->accessToken->jsonResponse("Cannot proceed login expired. Kindly logout and login again.", 400, "");
                }

                if($checkTime === 0){
                    return $this->accessToken->jsonResponse("Access denied !", 403, "");
                }


                if($checkTime === 2){
                    return $this->accessToken->jsonResponse("Access denied ! Facility credentials not allowed.", 403, "");
                }

            $openToken =  $this->accessToken->getAccessData($userData['token']);
            
            if($openToken === false){
                return $this->accessToken->jsonResponse("Invalid facility code!", 401, "");
            }

            
        $resultFacility = $this->db->selectTableData('hospital_facilities', '*', "facility_code='".$openToken['data']['facilityCode']."'", '');
                        
         
          if($resultFacility[0]['web_access'] != 1){
                return $this->accessToken->jsonResponse("Your facility is not allowed to access this portal.", 403,"");
                exit;
          }

         

            $newCode = $this->createFacilityNumber();
                //    var_dump($openToken['data']);

            

                $createData =  array(
                        "action_by"=> $openToken['data']['username'],
                        "facility_code"=> $newCode,
                        "hospital_name"=> $userData['facilityName'],
                        "address"=> $userData['faclilityAddress'],
                        "contact_officer"=> $userData['contactOfficer'],
                        "number"=>$userData['contactNumber'],
                        "web_access"=>$userData['webAccess']
                );

            if($userData['operation'] === 'new'){
                $result = $this->db->selectTableData('hospital_facilities', '*', "facility_code='" . $newCode . "' OR hospital_name='" . $userData['facilityName'] . "'", '');
                        if($result){
                            return $this->accessToken->jsonResponse("Facility ".$userData['facilityName']." already exsists!", 400, "");
                        }
                $submit = $this->db->insertTableData('hospital_facilities', $createData);


                }elseif($userData['operation'] === 'edit'){

                $conditions = [
                    'facility_code' => $userData['UpdatefacilityCode'] // This uniquely identifies the facility to update
                ];
                
                $data = $this->mapRequestData($userData);
                $data['edited_by'] = $openToken['data']['username'];
                $submit = $this->db->updateTableData('hospital_facilities', $data, $conditions);

            }
            
            if(!$submit){
                return $this->accessToken->jsonResponse("Cannot process at the moment.", 400, "");
            }else{
                return $this->accessToken->jsonResponse("Action successfull !", 200, "");
            }
        
        // else{
        //     return $this->accessToken->jsonResponse("Access denied!", 404,""); 
        // }
    }
    

}