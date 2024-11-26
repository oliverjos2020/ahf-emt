<?php
require_once('dbfunctions.php');
class AccessClass
{
    private $db; 
    private $encryptionKey ; // Use a strong secret key

    public function __construct() {
        $this->db = new Dbobject(); 
        $fetchKey = $this->db->getitemlabel('parameter', 'parameter_name', 'ENCRYPTION_KEY', 'parameter_value');
        $this->encryptionKey = $fetchKey; 
    }


    public function jsonResponse($message = "", $code = "", $data = "") {
        // Create the response array
        http_response_code($code);
        $responseArray = [
            'response_code' => $code,
            'response_message' => $message,
            'data' => $data
        ];
        
        header('Content-Type: application/json');
        if (!empty($message)) {
            header('X-Error-Message: ' . $message);
        }
        return $responseArray;
    }



    private function validateDecryptedData($data)
{
    // Ensure 'username' and 'password' are strings
    if (!is_string($data['username']) || !is_string($data['role_id'])) {
        return false;
    }

    // Ensure 'source' is a string (e.g., "web")
    if (!is_string($data['source'])) {
        return false;
    }

    // Ensure 'facilityCode' is a string (it can also be an integer, so you can modify this check accordingly)
    if (!is_string($data['facilityCode'])) {
        return false;
    }

    // Ensure 'loginDate' is a valid datetime string
    if (!strtotime($data['loginDate'])) {
        return false;
    }

    return true;
}


    // Method to encrypt data
    public function encrypt($data)
    {
       
        $data['loginDate'] = date('Y-m-d H:i:s'); 
        // var_dump($data);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encryptedData = openssl_encrypt(json_encode($data), 'aes-256-cbc', $this->encryptionKey, 0, $iv);
        return base64_encode($encryptedData . '::' . $iv);
    }

    // Method to decrypt data
    public function decrypt($encryptedData)
    {
        list($encryptedData, $iv) = explode('::', base64_decode($encryptedData), 2);
        return json_decode(openssl_decrypt($encryptedData, 'aes-256-cbc', $this->encryptionKey, 0, $iv), true);
    }

    // Method to validate input data
    public function validate($payload)
    {
        // Define required fields
        $requiredFields = ['username', 'facilityCode', 'role_id', 'source'];
        
        // Check if each required field is present, not empty, and not null
        foreach ($requiredFields as $field) {
            if (!isset($payload[$field]) || $payload[$field] === null || empty(trim($payload[$field]))) {
                return false; // Invalid input
            }
        }
        return true; // Valid input
    }
    

    // Method to generate the accessToken
    public function generateAccessToken($payload)
    {
        // Validate the input data
        if (!$this->validate($payload)) {
            return $this->jsonResponse("Invalid authorization. Empty field or incorrect data supplied.", 400, "");
        }

        return $this->jsonResponse("", 200, $this->encrypt($payload));
    }



    // Method to decrypt and return access data
    public function getAccessData($accessToken)
    {
        $decryptedData = $this->decrypt($accessToken);

        // Check if the decrypted data has the required keys
        $expectedKeys = ["username", "source", "facilityCode", "role_id", "loginDate"];
        $missingKeys = array_diff($expectedKeys, array_keys($decryptedData));

        if (empty($missingKeys) && $this->validateDecryptedData($decryptedData)) {
            return $this->jsonResponse("", 200, $decryptedData);
        } else {
            return $this->jsonResponse("Error in decryption", 400, "");
        }
    }




    public function checkLoginTime($userData){
        // var_dump($userData);
        $token = $userData['token'];
        $openToken =  $this->getAccessData($token);
        if(!$openToken){
         return 0;
        }
//  var_dump($openToken);
         $loginDate = $openToken['data']['loginDate'];
         $loginDateTime = new DateTime($loginDate);
         $currentDateTime = new DateTime();
         $timeDifference = $currentDateTime->diff($loginDateTime);
         $hoursDifference = $timeDifference->h + ($timeDifference->days * 24);
         if ($hoursDifference > 5) {
             // echo "Error: Login expired. More than 3 hours have passed.";
            return 1;
         } 

         

         $chkfacility = $this->verifyFacilityAccess($openToken['data']['facilityCode'], $openToken['data']['username']);
         if($chkfacility === false){
            return 2;
         }

    }


        public function verifyFacilityAccess($facilityCode,$username){
            $result = $this->db->selectTableData('userdata', '*', "username='".$username."'", '');
            if($result[0]['facility_code'] !== $facilityCode){
                return false;
            }

            $resultFacility = $this->db->selectTableData('hospital_facilities', '*', "facility_code='".$facilityCode."'", '');           
            if(!$resultFacility){
                return false;
            }else{
                if($resultFacility[0]['web_access'] != 1){
                    return false;
                    exit;
                }else{
                    return true;
                }
        }

    }
}


?>
