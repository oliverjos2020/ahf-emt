<?php
require_once('dbfunctions.php');

class ValidationClass {
    private $db; 
    private $error      = false;
    private $messageBag = array();


    public function __construct() {
        $this->db = new Dbobject(); 
    }
    // Define patterns for validation
    const NAME_PATTERN = "/^[A-Za-z]+$/"; // Single name
    const FULL_NAME_PATTERN = "/^[A-Za-z]+(?:[\s'-][A-Za-z]+)*$/"; // Full name with one space, ' or -
    const EMAIL_PATTERN = "/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/"; // Email format
    const PHONE_PATTERN = "/^\+?(\d{11,14})$/"; // Phone number allowing + and digits, with length 11 to 14
    const ADDRESS_PATTERN = "/^[A-Za-z0-9\s,()-]+$/"; // Address with letters, numbers, spaces, (),-, and ,




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
    // Define an array of disposable email domains (This can be expanded)
    const DISPOSABLE_EMAIL_DOMAINS = [
        'mailinator.com', 'guerrillamail.com', '10minutemail.com', 'temp-mail.org'
    ];



    public function validate(array $request, array $rulesPair, array $fieldAlias = array())
    {
        foreach($rulesPair as $key => $val)
        {
            $rules = explode('|',$val);
            foreach($rules as $rule_name)
            {
                $fieldAlias[$key] = ($fieldAlias[$key] == '')?$key:$fieldAlias[$key];
                $this->hasMetCondition($request,$key,$rule_name,$fieldAlias[$key]);
            }
        }
        return array('error'=>$this->error,'messages'=>$this->messageBag);
    }
    public function hasMetCondition($request,$key,$rule_to_validate,$alias)
    {
        $val = $request[$key];
        if(strpos($rule_to_validate,':') == false)
        {
            if($rule_to_validate == 'required')
            {
                if($key == "*")
                {
                    foreach($request as $row=>$v)
                    {
                        $this->checkRequired($v,$alias);
                    }
                }else
                {
                    $this->checkRequired($val,$alias);
                }
                
            }
            if($rule_to_validate == 'int')
            {
                if(!is_numeric($val))
                {
                    $this->error = true;
                    $this->messageBag[] = $alias.' field must be an integer';
                }
            }
            if($rule_to_validate == 'email')
            {
                $email = filter_var($val,FILTER_SANITIZE_EMAIL);
                if(!filter_var($val,FILTER_VALIDATE_EMAIL))
                {
                    $this->error = true;
                    $this->messageBag[] = $alias.' field must be a valid email';
                }
            }
        }else
        {
            $this->numericComparism($request,$key,$rule_to_validate,$alias);
        }
            
    }


    public function numericComparism($request,$key,$rule_to_validate,$alias)
    {
        $val = $request[$key];
        $r_rule = explode(':',$rule_to_validate);
        if($r_rule[0] == 'min' && strlen($val) < $r_rule[1])
        {
            $this->error = true;
            $this->messageBag[] = $alias.' field must have a minimum of '.$r_rule[1].' character.';
            return $this->error;
        }
        if($r_rule[0] == 'max' && strlen($val) > $r_rule[1])
        {
            $this->error = true;
            $this->messageBag[] = $alias.' field must have a maximum of '.$r_rule[1].' character.';
            return $this->error;
        }
        if($r_rule[0] == 'matches')
        {
//            echo $request[$r_rule[1]]."~".$val;
            if($val !== $request[$r_rule[1]] )
            {
                $this->error = true;
                $this->messageBag[] = $alias.' field does not match.';
                return $this->error;
            }
        }
        if($r_rule[0] == 'unique')
        {
            $tbl_field = explode('.',$r_rule[1]);

            
            $res = $this->db->getitemlabel($tbl_field[0] ,$tbl_field[1], $val, $tbl_field[1]);
            if($res > 0)
            {
                $this->error = true;
                $this->messageBag[] = $alias.' already exist ';
                return $this->error;
            }
        }
    }

    public function checkRequired($value,$alias)
    {
        if($value == "" || $value == null)
        {
            $this->error = true;
            $this->messageBag[] = $alias.' field is required.';
            return $this->error;
        }
    }


    // Single name validation (e.g., John, not John Doe)
    public function validateSingleName($name) {
        if (!preg_match(self::NAME_PATTERN, $name)) {
            return  $this->jsonResponse("Invalid name. Only a single word without spaces or special characters is allowed." , 400, "");
           
        }
        return true;
    }

    // Full name validation (e.g., John Doe Frank, allowing only one space, ' or -)
    public function validateFullName($fullName) {
        if (!preg_match(self::FULL_NAME_PATTERN, $fullName)) {
            return  $this->jsonResponse("Invalid full name. Only letters, one space, apostrophes, or hyphens are allowed." , 400, "");
   
        }
        return true;
    }

    // Email validation with disposable email check
    public function validateEmail($email) {
        if (!preg_match(self::EMAIL_PATTERN, $email)) {
        
            return  $this->jsonResponse("Invalid email format." , 400, "");
            exit;
        }
        // Check for disposable email domains
        $domain = substr(strrchr($email, "@"), 1); // Get the domain part of the email
        if (in_array($domain, self::DISPOSABLE_EMAIL_DOMAINS)) {
            return  $this->jsonResponse("Disposable email addresses are not allowed." , 400, "");
            exit;
        }
        return true;
    }

    // Phone number validation (e.g., 08038700372 or +2348038700372)
    public function validatePhoneNumber($phone) {
        // Remove spaces
        $phone = str_replace(' ', '', $phone);
        if (!preg_match(self::PHONE_PATTERN, $phone)) {
            return  $this->jsonResponse("Invalid phone number. It must contain between 11 and 14 digits, and can optionally start with a '+'." , 400, "");
         
        }
        return true;
    }
    

    // Address validation (e.g., allowing letters, numbers, spaces, commas, (), and -)
    public function validateAddress($address) {
        if (!preg_match(self::ADDRESS_PATTERN, $address)) {
            return  $this->jsonResponse("Invalid address. Only letters, numbers, spaces, commas, parentheses, and hyphens are allowed." , 400, "");
        }
        return true;
    }
}
