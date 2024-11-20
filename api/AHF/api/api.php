<?php
require_once 'encryption_manager.php'; 
require_once '../lib/patientClass.php';
require_once '../lib/usersClass.php';
require_once('../lib/facilitiesClass.php');  
require_once('../lib/accessClass.php');



// Required headers for CORS and allowed methods
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// $encryption_key = '8748HGbd2873uwh';  
// $encryption_manager = new EncryptionManager($encryption_key);  

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_data = json_decode(file_get_contents("php://input"), true);  
}else{
    $res = array("response_code" => 400, "response_message" => "Invalid request format. 'payload' field is required.");
    echo json_encode($res); // Return the JSON response directly
    exit;
}

// Step 1: Receive Encrypted Data

// var_dump($input_data);



if (!isset($input_data['payload']) || empty($input_data['payload'])) {
    // Return an error response for missing or empty payload
    $res = array("response_code" => 400, "response_message" => "Invalid request format. 'payload' field is required.");
    // Encrypt the error response (commented out)
    // $response = json_encode($res);
    // $encrypted_response = $encryption_manager->encrypt($response); // Encrypt the error response
    echo json_encode($res); // Return the JSON response directly
    exit;
}

$encrypted_payload = $input_data['payload'];  // Extract the payload (encrypted data)

// Step 2: Decrypt the payload using the EncryptionManager (commented out)
// $payload = $encryption_manager->decrypt($encrypted_payload);  // Decrypt the payload
$payload = $encrypted_payload;  // Use the payload directly without decryption
$request = $payload;  // Decode the JSON data




if (!isset($request['facilityCode']) || empty($request['facilityCode'])) {
    
    if (!isset($payload['token']) || empty($payload['token'])) {
        $errorResponse = array("response_code" => 400, "response_message" => "Access token and authorization required!");
        echo json_encode($errorResponse);
        exit; 
    }
    // Handle the missing or empty facilityCode
    $accessToken = new AccessClass(); 
    $validateToken = $accessToken->getAccessData($payload['token']);
    if($validateToken['response_code'] != 200){
        $errorResponse = array("response_code" => 400, "response_message" => $validateToken['response_message']);
        echo json_encode($errorResponse);
        exit;
    }else{
        $tokenData = $validateToken;
        $payload['tokenData']= $tokenData['data'];
    }
   

} else {
    // Proceed with the facility code validation
    $checkFacility = new FacilitiesClass(); 
    $result = $checkFacility->validateFacility($request['facilityCode']);

    if ($result['response_code'] === 400) {
        $errorResponse = array("response_code" => 400, "response_message" => $result['message']);
        echo json_encode($errorResponse);
        exit;
    } elseif ($result['response_code'] === 200) {
        $facilityData = $result['data']; 
        // You may want to process or return $facilityData here
    } else {
        $unknownResponse = array("response_code" => 500, "response_message" => "Unexpected error occurred");
        echo json_encode($unknownResponse);
        exit;
    }
}






// Step 3: Store request in folder named 'logger', organized by year and month
$currentYear = date('Y');
$currentMonth = date('m');
$currentDate = date('Y-m-d');

// Define the base log directory
$base_log_dir = __DIR__ . '/logger/';

// Create year and month directories if they don't exist
$year_log_dir = $base_log_dir . $currentYear . '/';
$month_log_dir = $year_log_dir . $currentMonth . '/';

if (!is_dir($year_log_dir)) {
    mkdir($year_log_dir, 0777, true);  // Create year directory
}

if (!is_dir($month_log_dir)) {
    mkdir($month_log_dir, 0777, true);  // Create month directory
}

// Define the log file for today
$log_file = $month_log_dir . $currentDate . '.txt';  // Daily log file
$log_entry = "[" . date('Y-m-d H:i:s') . "] " . json_encode($request, JSON_PRETTY_PRINT) . "\n\n";  // Add timestamp and request data


if (!file_exists($log_file)) {
    file_put_contents($log_file, ''); 
}


file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);

$request_uri = $_SERVER['REQUEST_URI']; 
$path = parse_url($request_uri, PHP_URL_PATH); 
$segments = explode('/', trim($path, '/'));

$endpoint = end($segments); 

$response = null;  

if (!empty($endpoint)) {  
   


    $usersResources = new UserClass($payload); 
    $resourceFacility = new FacilitiesClass();
    
    if ($endpoint == "setupPatient") {
        $resource = new PatientClass($payload);
        $response = $resource->patientManager($payload); 
    }elseif ($endpoint == "patientsData") {
        $resource = new PatientClass($payload);
        $response = $resource->getPatientData($payload);
        
    }elseif ($endpoint == "newVisit") {
        $resource = new PatientClass($payload);
        $response = $resource->setupNewVisit($payload);
        
    } elseif ($endpoint == "userLogin") {
        $response = $usersResources->userLogin($payload);
      
    }elseif ($endpoint == "setupFacility") {
        $response = $resourceFacility->facilitySetup($payload);
        
    } else {
        $res = array("response_code" => 404, "response_message" => "Endpoint not found.");
        $response = ($res);
    }
} else {
   
    $res = array("response_code" => 400, "response_message" => "Invalid request.", "data" => "");
    $response = ($res);
}


// $encrypted_data = $encryption_manager->encrypt($response);  // Encrypt the JSON response
// $formatted_response = array("payload" => $encrypted_data); // Format the response

// Return the formatted JSON response directly
echo json_encode($response); // Send the JSON response directly


