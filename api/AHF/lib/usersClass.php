<?php
require_once('dbfunctions.php');
require_once('validateionClass.php');
require_once('sendMailClass.php');
require_once('accessClass.php');
require_once('../libs/desencrypt.php');


class UserClass {
    private $db; 
    private $validator; 
    private $mailSender; 
    private $checkFacility;
    private $accessToken;

    public function __construct() {
        $this->db = new Dbobject(); 
        $this->validator = new ValidationClass(); 
        $this->mailSender = new SendEmail(); 
        $this->checkFacility = new FacilitiesClass(); 
        $this->accessToken = new AccessClass(); 
    }


    // public function jsonResponse($message = "", $code = "", $data = "") {
    //     // Create the response array
    //     $responseArray = [
    //         'status' => $code,
    //         'message' => $message,
    //         'data' => $data
    //     ];
        
    //     // Return the JSON-encoded response
    //     return $responseArray;
    // }

  

    public function userLogin($userData){
       
        $username = $userData['username'];
        $password = $userData['password'];
        $validate = $this->validator->validate(
            $userData,
            array('username' => 'required|email', 'password' => 'required'),
            array('username' => 'Username', 'password' => 'Password')
        );
        if($validate['error'])
        {
            return $this->accessToken->jsonResponse("Username or password missing!", 404,"");
        }
            else{
                $result = $this->db->selectTableData('userdata', '*', "username='".$userData['username']."'", '');

                if(!$result){

                    return $this->accessToken->jsonResponse("Login Failed!", 400,"");

                    }else{
      
                        $encrypted_password = $result[0]['password'];
                        $is_locked     = $result[0]['user_locked'];
                        $is_disabled     = $result[0]['user_disabled'];
                        // $verify_pass   = password_verify($password,$hash_password);

                        $desencrypt = new DESEncryption();
                        $key = $username;
                        $cipher_password = $desencrypt->des($key, $password, 1, 0, null,null);
                        $str_cipher_password = $desencrypt->stringToHex ($cipher_password);
                        if($str_cipher_password == $encrypted_password)
                        // if(1 == 1)
                        {
                            $chkfacility = $this->accessToken->verifyFacilityAccess($userData['facilityCode'], $username);

                           
                            if($chkfacility === false){

                                return $this->accessToken->jsonResponse("Login failed! Facility not detected or not allowed.", 400,"");
            
                                }else{
                                    $resultFacility = $this->db->selectTableData('hospital_facilities', '*', "facility_code='".$userData['facilityCode']."'", '');
                        
                                    if($resultFacility[0]['web_access'] != 1){
                                        return $this->accessToken->jsonResponse("Your facility is not allowed to access this portal.", 400,"");
                                        exit;
                                    }else{
                                        $userData['role_id'] = $result[0]['role_id'];
                                        if (isset($userData['password'])) {
                                            unset($userData['password']); // Remove the password field
                                        }
                                        $generateToken =  $this->accessToken->generateAccessToken($userData);
    
      
                                        if($generateToken['response_code'] != 200){
                                            return $this->accessToken->jsonResponse($generateToken['message'], 400, "");
                                        }

                                        return $this->accessToken->jsonResponse(
                                            "Login Successfull!", 
                                            200,
                                            array("token"=> $generateToken['data'])
                                        );
                            

                                        }

                            }

                    }else{
                        return $this->accessToken->jsonResponse("Username or password incorrect!", 404,""); 
                    }
                }
            }
    }











}