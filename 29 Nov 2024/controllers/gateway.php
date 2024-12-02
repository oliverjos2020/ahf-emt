<?php
include 'cookieManager.php';
define('TECHHOSTURL', 'https://ahf.accessng.com/api/v1/');
class gateway extends cookieManager
{

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
        $payload['token'] = "";
        $payload['webFlag'] = 1;

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
        return true;
    }


    public function checkRoute($data)
    {
        $currentTime = time(); // Unix timestamp
        $timer = $this->pickCookieTimer();

        if (!$timer) {
            throw new Exception("Token timer cookie is missing or invalid.");
        }

        $timerTimestamp = strtotime($timer);
        if ($currentTime > $timerTimestamp) {
            // Call endpoint to regenerate token
            $this->regenerateToken();
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
