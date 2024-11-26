<?php

// Include or require the class file if needed
require_once 'encryption_manager.php';

// Your encryption key
$key = '8748HGbd2873uwh';  

// Create an instance of EncryptionManager
$encryptionManager = new EncryptionManager($key);

// Get the endpoint from the query string
$endpoint = isset($_GET['endpoint']) ? $_GET['endpoint'] : 'default';

// Set the content type to application/json
header('Content-Type: application/json');

switch ($endpoint) {
    case 'encrypt':
        // Read the JSON data from the request body
        $input = json_decode(file_get_contents('php://input'), true);
        
        // Check if the 'payload' field is provided
        if (isset($input['payload'])) {
            // Encrypt the payload
            $encrypted_data = $encryptionManager->encrypt(json_encode($input['payload']));
            
            // Respond with the encrypted data
            echo json_encode(['payload' => $encrypted_data]);
        } else {
            // Respond with an error message if 'payload' is not provided
            echo json_encode(['error' => 'No payload provided for encryption.']);
        }
        break;

    case 'decrypt':
        // Read the JSON data from the request body
        $input = json_decode(file_get_contents('php://input'), true);
        
        // Check if the 'payload' field is provided
        if (isset($input['payload'])) {
            // Decrypt the data
            $decrypted_data = $encryptionManager->decrypt($input['payload']);
            
            // Respond with the decrypted data
            echo json_encode(['payload' => json_decode($decrypted_data, true)]);
        } else {
            // Respond with an error message if 'payload' is not provided
            echo json_encode(['error' => 'No payload provided for decryption.']);
        }
        break;

    default:
        echo json_encode(['error' => 'Invalid endpoint.']);
        break;
}
?>
