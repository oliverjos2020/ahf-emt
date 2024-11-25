<?php
define('TECHHOSTURL', 'https://ahf.accessng.com/api/v1/');
class gateway
{

    public function callAPI($payload)
    {
        include 'cookieManager.php';
        $cookieManager = new CookieManager();

        $route = $payload['route'];
        $list = $payload['list'] ?? '';
        $filename = '../Logs/' . date('Y') . '/' . date('M') . '/';
        if (!file_exists($filename)) {
            mkdir($filename, 0777, true);
        }
        unset($payload['route']);
        unset($payload['list']);

        $payload['token'] = $cookieManager->pickCookieToken();
        $payload['webFlag'] = 1;
        // print_r($payload);exit;
        $body = ['payload' => $payload];
        $bodyEnc = json_encode($body);

        // print_r(json_encode($body));exit;
        $file_content1 = 'Logged @ ' . date('Y-m-d H:i:s') . ' Data=>' . json_encode($body, JSON_PRETTY_PRINT) . PHP_EOL;
        $filename2 = $filename . '/Data_sent_' . date('d') . '.txt';
        file_put_contents($filename2, $file_content1, FILE_APPEND . PHP_EOL);

        // cURL Request
        $send = curl_init();
        curl_setopt($send,CURLOPT_URL,TECHHOSTURL . $route);
        curl_setopt($send, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($send, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($send, CURLOPT_SSL_VERIFYHOST, 2); 
        curl_setopt($send, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($send, CURLOPT_POSTREDIR, 3);
        curl_setopt($send, CURLOPT_POST, true); 
        curl_setopt($send, CURLOPT_POSTFIELDS, $bodyEnc);

        $response = curl_exec($send);	
        $resp = json_decode($response, true);
        $file_content3 = 'Logged @ ' . date('Y-m-d H:i:s') . ' Data=>' . json_encode($resp, JSON_PRETTY_PRINT) . PHP_EOL;
        $filename3 = $filename . '/Data_recieved_' . date('d') . '.txt';
        file_put_contents($filename3, $file_content3, FILE_APPEND . PHP_EOL);
        curl_close($send);

        if (isset($resp['data']['token'])) {
            $cookieManager->dropCookie($resp['data']); // Drop cookie with the data
        }
        if($list == 'yes'){
            echo json_encode($resp['data']);
        }else{
            echo $response;
        }
        
    }


    public function checkRoute($data)
    {
        // Check if 'route' key exists in the data
        if (!array_key_exists('route', $data)) {
            return json_encode([
                'response_code' => 204,
                'response_message' => 'Route Field is required.'
            ]);
        }
        return null;  // Return null if the route is present
    }

    public function registerUser($data)
    {
        $cookieManager = new CookieManager();
        // check if record does not exists before then insert
        $data['day_1'] = (isset($data['day_1'])) ? 1 : 0;
        $data['day_2'] = (isset($data['day_2'])) ? 1 : 0;
        $data['day_3'] = (isset($data['day_3'])) ? 1 : 0;
        $data['day_4'] = (isset($data['day_4'])) ? 1 : 0;
        $data['day_5'] = (isset($data['day_5'])) ? 1 : 0;
        $data['day_6'] = (isset($data['day_6'])) ? 1 : 0;
        $data['day_7'] = (isset($data['day_7'])) ? 1 : 0;
        $data['passch_logon'] = (isset($data['passch_logon'])) ? 1 : 0;
        $data['user_disabled'] = (isset($data['user_disabled'])) ? 1 : 0;
        $data['user_locked'] = (isset($data['user_locked'])) ? 1 : 0;


        if ($data['operation'] != 'edit') {
            $validation = $this->validate(
                $data,
                array(
                    'firstname' => 'required|min:2',
                    'lastname' => 'required',
                    'role_id' => 'required',
                    'email' => 'required|email|unique:userdata.username',
                    'password' => 'required|min:6',
                    'sex' => 'required',
                    'mobile_phone' => 'required'
                ),
                array(
                    'email' => 'Email',
                    'password' => 'Password',
                    'firstname' => 'First Name',
                    'lastname' => 'Last Name',
                    'othername' => 'Othername',
                    'role_id' => 'Role ID',
                    'sex' => 'Gender',
                    'mobile_phone' => 'Phone Number'
                )
            );


            if (!$validation['error']) {

                $payload = [
                    "payload" => [
                        "token" => $cookieManager->pickCookieToken(),
                        "operation" => "new",
                        "password" => $data['password'],
                        // "role_id" =>is_array($data['role_id']) ? $data['role_id'] : [$data['role_id']],
                        "role_id" => $data['role_id'],
                        "facility_code" => $data['facility_code'],
                        "firstname" => $data['firstname'],
                        "lastname" => $data['lastname'],
                        "email" => $data['email'],
                        "sex" => $data['sex'],
                        "mobile_phone" => $data['mobile_phone'],
                        "day_1" => $data['day_1'],
                        "day_2" => $data['day_2'],
                        "day_3" => $data['day_3'],
                        "day_4" => $data['day_4'],
                        "day_5" => $data['day_5'],
                        "day_6" => $data['day_6'],
                        "day_7" => $data['day_7'],
                        "passchg_logon" => 0,
                        "user_disabled" => 0,
                        "user_locked" => $data['user_locked'],
                        "route" => "registerUser"
                    ]
                ];
                //    var_dump($payload);exit;
                // return $this->makeAPICall(,$payload);

                return $this->callApi2("registerUser", $payload);
            } else {
                return json_encode(array("response_code" => 20, "response_message" => $validation['messages'][0]));
            }
        } else {

            $data['modified_date'] = date('Y-m-d h:i:s');
            $validation = $this->validate(
                $data,
                array(
                    'firstname' => 'required|min:2',
                    'lastname' => 'required',
                    'role_id' => 'required',
                    'username' => 'required',
                    'sex' => 'required'
                ),
                array(
                    'username' => 'Username',
                    'firstname' => 'First Name',
                    'lastname' => 'Last Name',
                    'role_id' => 'Role ID',
                    'sex' => 'Gender',
                )
            );

            if (!$validation['error']) {
                $payload = [
                    "token" => $cookieManager->pickCookieToken(),
                    "operation" => "edit",
                    "password" => $data['password'],
                    "role_id" => $data['role_id'],
                    "firstname" => $data['firstname'],
                    "facility_code" => $data['facility_code'],
                    "lastname" => $data['lastname'],
                    "email" => $data['email'],
                    "sex" => $data['sex'],
                    "mobile_phone" => $data['mobile_phone'],
                    "day_1" => $data['day_1'],
                    "day_2" => $data['day_2'],
                    "day_3" => $data['day_3'],
                    "day_4" => $data['day_4'],
                    "day_5" => $data['day_5'],
                    "day_6" => $data['day_6'],
                    "day_7" => $data['day_7'],
                    "passchg_logon" => 0,
                    "user_disabled" => 0,
                    "user_locked" => $data['user_locked'],
                    "route" => "registerUser"
                ];

                // var_dump($payload);
                // exit;
                // Check if 'route' is present before calling the API
                $routeCheck = $this->checkRoute($payload);
                if ($routeCheck) {
                    echo $routeCheck;  // Return error if 'route' is missing
                } else {
                    return $this->callAPI($payload);  // Proceed with the API call
                }
            } else {
                return json_encode(array("response_code" => 20, "response_message" => $validation['messages'][0]));
            }
        }
    }

    public function userlist($data)
    {

        $apiResponse = $this->getUserList($data);
        $response = json_decode($apiResponse, true);

        // Ensure the response structure is valid
        if ($response['response_code'] != 200 || !isset($response['data']['data'])) {
            echo json_encode([
                'draw' => $response['data']['draw'] ?? 0,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ]);
            return;
        }

        $apiData = $response['data']['data']; // Extract the array of users

        // Prepare the final output for the DataTable
        $result = [];
        foreach ($apiData as $row) {
            $username = $row['3'][0] ?? ''; // Extract username
            $user_disabled = ($row['7'][0] == 'Enabled') ? 0 : 1;

            // Add the row data
            $result[] = [
                $row['0'][0] ?? '', // ID
                $row['1'][0] ?? '', // First Name
                $row['2'][0] ?? '', // Last Name
                // $username,          // Username
                $row['4'][0] ?? '', // Mobile Phone
                $row['5'][0] ?? '', // Role
                $row['6'][0] ?? '', // Email
                $row['7'][0] ?? '', // Status (Enabled/Disabled)
                // Action button for enabling/disabling users
                "<button onclick=\"trigUser('$username', '$user_disabled')\" class='btn btn-sm " .
                    (($user_disabled == 1) ? "btn-success" : "btn-danger") . "'>" .
                    (($user_disabled == 1) ? "Enable" : "Disable") . "</button>",
                // Action button for editing users
                "<a class='btn btn-sm btn-success' onclick=\"myLoadModal('modules/user/user.php?op=edit&username=$username','modal_div')\" 
                href=\"javascript:void(0)\" data-toggle=\"modal\" data-target=\"#defaultModalPrimary\">Edit</a>",
                $row['10'][0] ?? '' // Created Date
            ];
        }

        // Output the result in the DataTable format
        echo json_encode([
            'draw' => $response['data']['draw'] ?? 1,
            'recordsTotal' => $response['data']['recordsTotal'] ?? 0,
            'recordsFiltered' => $response['data']['recordsFiltered'] ?? 0,
            'data' => $result
        ]);
    }

    function getUserList($data)
    {
        $data['op'] = 'Patients.fetchPatients';
        $endpoint = "usersList";
        // Add token and username to the payload
        $payload = [
            "payload" => array_merge($data, [
                "token" => "WWtOVURsQWl0QlcwNzlYeEZoeVk4a2JPcUphVXdPVDVObUV6ckNYZ3FuZEJoYXM3dU95RjJSUG56WGFKYmtOU0Q1N2ZSZnRIME9FUjhSWERvV3VqaFUxYnFkVm5DVDlub0NReE5aa0d2NzVqNkYvQUxENi9RdTgwRTR3VGxvSll4ZGJGZmFpOVJjMzY4S0pnZWVzTm5meU5tL2VmQUNKVXNVUUtLczhpSDU0PTo6xLYp7JuA/ySv9EKAa6r1Rg==",
                "username" => "ness7@live.com"
            ])
        ];

        // Call the API using the callApi() function
        $response = $this->callAPI2($endpoint, $payload);


        return $response;
    }

    public function fetchUsersData()
    {
        $payload = [
            "route" => "userlist"
        ];

        return $this->callAPI($payload);
    }

    function callApi2($endpoint, $payload)
    {
        // Initialize cURL session
        $curl = curl_init();

        // Convert the payload array to JSON
        $jsonPayload = json_encode($payload);

        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => TECHHOSTURL . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonPayload,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Cookie: PHPSESSID=l711vsulpqupg5ic6os2lcgnp8'
            ),
        ));

        // Execute the request and capture the response
        $response = curl_exec($curl);

        // Check for cURL errors
        if (curl_errno($curl)) {
            $errorMsg = 'cURL Error: ' . curl_error($curl);
            curl_close($curl);
            return $errorMsg;
        }

        // Close the cURL session
        curl_close($curl);

        // Return the API response
        return $response;
    }
}

// Usage Example
$gateway = new Gateway();

// Check if 'route' is present before calling the API
$routeCheck = $gateway->checkRoute($_REQUEST);
if ($routeCheck) {
    echo $routeCheck;  // Return error if 'route' is missing
} else {
    return $gateway->callAPI($_REQUEST);  // Proceed with the API call
}
