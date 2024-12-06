<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'cookieManager.php';
define('TECHHOSTURL', 'https://ahf.accessng.com/api/v1/');
class gateway extends cookieManager
{

    // public function callAPI($payload)
    // {
    //     try {
    //         $route = $payload['route'] ?? throw new Exception('Route is required');
    //         $list = $payload['list'] ?? '';
    //         $filename = '../Logs/' . date('Y') . '/' . date('M') . '/';
            
    //         // Create log directory with proper permissions
    //         if (!file_exists($filename)) {
    //             mkdir($filename, 0755, true);
    //         }

    //         unset($payload['route'], $payload['list']);

    //         $token = $this->pickCookieToken(); // Get the token from CookieManager
    //         $body = ['payload' => $payload];
    //         $bodyEnc = json_encode($body);

    //         // Log sent data
    //         $this->logData($filename . '/Data_sent_' . date('d') . '.txt', $body);

    //         // Improved cURL configuration
    //         $send = curl_init();
    //         curl_setopt_array($send, [
    //             CURLOPT_URL => TECHHOSTURL . $route,
    //             CURLOPT_SSL_VERIFYPEER => false,  // Enable SSL verification
    //             CURLOPT_SSL_VERIFYHOST => 2,     // Strict host verification
    //             CURLOPT_FOLLOWLOCATION => true,
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_POSTREDIR => 3,
    //             CURLOPT_POST => true,
    //             CURLOPT_POSTFIELDS => $bodyEnc,
    //             CURLOPT_HTTPHEADER => [
    //                 'Authorization: Bearer ' . $token,
    //                 'Content-Type: application/json'
    //             ],
    //             CURLOPT_TIMEOUT => 30,  // 30-second timeout
    //             CURLOPT_CONNECTTIMEOUT => 10  // 10-second connection timeout
    //         ]);

    //         $response = curl_exec($send);
    //         $curlError = curl_error($send);
    //         $httpCode = curl_getinfo($send, CURLINFO_HTTP_CODE);

    //         curl_close($send);

    //         // Handle potential errors
    //         if ($curlError) {
    //             throw new Exception('cURL Error: ' . $curlError);
    //         }

    //         // Check for empty response
    //         if (empty($response)) {
    //             $errorResponse = json_encode([
    //                 'status' => 'error',
    //                 'message' => 'No response received from server. Please try again.',
    //                 'http_code' => $httpCode
    //             ]);
                
    //             $this->logData($filename . '/Error_' . date('d') . '.txt', ['error' => $errorResponse]);
    //             echo $errorResponse;
    //             return;
    //         }

    //         $resp = json_decode($response, true);

    //         // Log received data
    //         $this->logData($filename . '/Data_received_' . date('d') . '.txt', $resp);

    //         // Handle token regeneration
    //         if (isset($resp['data']['token'])) {
    //             $this->dropCookie($resp['data']);
    //         }

    //         // Return results based on list flag
    //         echo ($list == 'yes') ? json_encode($resp['data']) : $response;

    //     } catch (Exception $e) {
    //         $errorResponse = json_encode([
    //             'status' => 'error',
    //             'message' => $e->getMessage()
    //         ]);
    //         echo $errorResponse;
    //     }
    // }


    public function callAPI($payload)
    {
        // include 'cookieManager.php';
        // $cookieManager = new CookieManager();

        $route = $payload['route'];
        $list = $payload['list'] ?? '';
        $filename = '../Logs/' . date('Y') . '/' . date('M') . '/';
        if (!file_exists($filename)) {
            mkdir($filename, 0777, true);
        }
        unset($payload['route']);
        unset($payload['list']);

        $token = $this->pickCookieToken(); // Get the token from CookieManager
        // $payload['token'] = "";
        // $payload['webFlag'] = 0;

        $body = ['payload' => $payload];
        $bodyEnc = json_encode($body);

        // print_r($token); exit;

        $file_content1 = 'Logged @ ' . date('Y-m-d H:i:s') . ' Data=>' . json_encode($body, JSON_PRETTY_PRINT) . PHP_EOL;
        $filename2 = $filename . '/Data_sent_' . date('d') . '.txt';
        file_put_contents($filename2, $file_content1, FILE_APPEND . PHP_EOL);

        // cURL Request
        $send = curl_init();
        curl_setopt($send, CURLOPT_URL, TECHHOSTURL . $route);
        curl_setopt($send, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($send, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($send, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($send, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($send, CURLOPT_POSTREDIR, 3);
        curl_setopt($send, CURLOPT_POST, true);
        curl_setopt($send, CURLOPT_POSTFIELDS, $bodyEnc);

        // Add headers with Bearer token
        $headers = [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ];
        curl_setopt($send, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($send);
        $resp = json_decode($response, true);
        $file_content3 = 'Logged @ ' . date('Y-m-d H:i:s') . ' Data=>' . json_encode($resp, JSON_PRETTY_PRINT) . PHP_EOL;
        $filename3 = $filename . '/Data_recieved_' . date('d') . '.txt';
        file_put_contents($filename3, $file_content3, FILE_APPEND . PHP_EOL);
        curl_close($send);

        if (isset($resp['data']['token'])) {
            $this->dropCookie($resp['data']); // Drop cookie with the data
        }

        if ($list == 'yes') {
            echo json_encode($resp['data']);
        } else {
            echo $response;
        }
    }

    public function regenerateToken()
    {

        $regenerateToken = $this->regenToken();
        $payload = ['payload' => ["regenerateToken" => $regenerateToken]];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => TECHHOSTURL . '/generateToken',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [],
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $resp = json_decode($response, true);
        $token = $resp['data'];
        
        $currentTime = date('Y-m-d H:i:s');
        $TenMinBeforeExp = date('Y-m-d H:i:s', strtotime($currentTime . ' + 10 minutes'));
        
        setcookie('token', $token, time() + (6 * 3600), '/', '', true);
        setcookie('cookieTimer', $TenMinBeforeExp, time() + (24 * 3600), '/', '', true);
        // print_r($TenMinBeforeExp);
        // exit;
        return true;
    }




    public function checkRoute($data)
    {
        $currentTime = time(); // Unix timestamp
        $timer = $this->pickCookieTimer();
        if(empty($timer))
        {
            $timer = date('Y-m-d H:i:s');
        }

        // if (!$timer) {
        //     // throw new Exception("Token timer cookie is missing or invalid.");
        // }

        $timerTimestamp = strtotime($timer);
        if ($currentTime > $timerTimestamp) {
            // die("Time has expired: $currentTime");
            // Call endpoint to regenerate token
            $this->regenerateToken();
            // die();
        }else{
            // die("Time is remaining: $timerTimestamp");
        }

        if (!array_key_exists('route', $data)) {
            return json_encode([
                'response_code' => 204,
                'response_message' => 'Route Field is required.'
            ]);
        }

        return null; // Return null if everything is fine
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
