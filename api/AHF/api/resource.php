<?php

require_once 'encryption_manager.php'; 
require_once '../lib/usersClass.php'; 

class Resource {
    private $payloadData;  
    private $encryptionManager; 
    private $inputValidations;
    private $usersActions;

    // Constructor accepts encrypted payload and encryption key
    public function __construct($encryptedPayload, $encryptionKey) {
        $this->encryptionManager = new EncryptionManager($encryptionKey);
        $this->inputValidations = new ValidationClass();
        $this->usersActions = new UserClass();
        $this->payloadData = $encryptedPayload;
    }



    public function createNewAccount() {
        // Access the decrypted request data
        $sentData = $this->payloadData; 
        $createUser = $this->usersActions->managePatient($sentData);
        if ($createUser[1] !== 200) {
            return $this->jsonResponse($createUser[0], $createUser[1], $createUser[2]);  
        }else{
            return $this->jsonResponse($createUser[0], $createUser[1], $createUser[2]);  
        }
    }





    public function editAccountDetails() {
        // Access the decrypted request data
        $sentData = $this->payloadData;

        // Logic for editing account details

        // Success response
        return $this->jsonResponse("Account details updated successfully!", 200, [
            // Include updated account details in the response
            'email' => $sentData->email,
            // other details
        ]);
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
}
