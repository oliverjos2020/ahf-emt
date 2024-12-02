<?php
Class cookieManager{
    public function dropCookie($data)
    {
        // print_r($data);exit;
        $arr = [
            "role" => $data['role_id_sess'][0]['role_name'],
            "roleId" => $data['role_id_sess'][0]['role_id'],
            "username" => $data['username_sess'],
            "firstname" => $data['firstname'],
            "lastname" => $data['lastname'],
            "facilityName" => $data['facilityName'],
            "facilityId" => $data['facilityId'],
            "menu" => $data['menu'],
        ];
        $cookieValue = json_encode($arr);
        $currentTime = date('Y-m-d H:i:s');
        $TenMinBeforeExp = date('Y-m-d H:i:s', strtotime($currentTime . ' + 10 minutes'));
        
        // Set the cookie (valid for 1 hour)
        setcookie('userRecord', $cookieValue, time() + (3 * 3600), '/'); // Basic cookie
        setcookie('token', $data['token'], time() + (3 * 3600), '/', '', true); // Secure and HttpOnly
        setcookie('cookieTimer', $TenMinBeforeExp, time() + (3 * 3600), '/', '', true); // Secure and HttpOnly
        setcookie('regenerateToken', $data['regenerateToken'], time() + (3 * 3600), '/', '', true); // Secure and HttpOnly
        
        if (isset($_COOKIE['userRecord'])) {
            return true;
        } else {
            return false;
        }
    }

    public function pickCookie()
    {
        // Retrieve the cookie value
        if (isset($_COOKIE['userRecord'])) {
            // Decode the JSON back to an array
            return json_decode($_COOKIE['userRecord'], true);
        }
    }
    public function pickCookieToken()
    {
        // Retrieve the cookie value
        if (isset($_COOKIE['token'])) {
            // Decode the JSON back to an array
            return $_COOKIE['token'];
        }
    }
    public function pickCookieTimer()
    {
        // Retrieve the cookie value
        if (isset($_COOKIE['cookieTimer'])) {
            // Decode the JSON back to an array
            return $_COOKIE['cookieTimer'];
        }
    }
    public function regenToken()
    {
        // Retrieve the cookie value
        if (isset($_COOKIE['regenerateToken'])) {
            // Decode the JSON back to an array
            return $_COOKIE['regenerateToken'];
        }
    }
}