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
            "menu" => $data['menu']
        ];
        $arrOptions = [
            "opportunisticInfection" => $data['option_opportunistic_infection'],
            "familyPlanning" => $data['option_family_planning'],
            "functionalStatus" => $data['option_functional_status'],
            "tbScreening" => $data['option_tb_screening'],
            "cryptococcal" => $data['option_cryptococcal_screening'],
            "hepatitis" => $data['option_hepatitis_screening'],
            "why" => $data['sel_why']
        ];
        $arrSymptoms = [
            "symptoms" => $data['symptoms']
        ]; 
        $options = json_encode($arrOptions);
        $symptoms = json_encode($arrSymptoms);
        $cookieValue = json_encode($arr);
        $currentTime = date('Y-m-d H:i:s');
        $TenMinBeforeExp = date('Y-m-d H:i:s', strtotime($currentTime . ' + 10 minutes'));
        
        // Set the cookie (valid for 1 hour)
        setcookie('userRecord', $cookieValue, time() + (3 * 3600), '/'); // Basic cookie
        setcookie('options', $options, time() + (3 * 3600), '/'); // Basic cookie
        setcookie('symptoms', $symptoms, time() + (3 * 3600), '/'); // Basic cookie
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
    public function pickCookieOptions()
    {
        // Retrieve the cookie value
        if (isset($_COOKIE['options'])) {
            // Decode the JSON back to an array
            return json_decode($_COOKIE['options'], true);
        }
    }
    public function pickCookieSymptoms()
    {
        // Retrieve the cookie value
        if (isset($_COOKIE['symptoms'])) {
            // Decode the JSON back to an array
            return json_decode($_COOKIE['symptoms'], true);
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