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
            "menu" => $data['menuenu'],
        ];
        $cookieValue = json_encode($arr);
        // Set the cookie (valid for 1 hour)
        setcookie('userRecord', $cookieValue, time() + 3600, '/'); // Basic cookie
        setcookie('token', $data['token'], time() + 3600, '/', '', true); // Secure and HttpOnly
    
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
}