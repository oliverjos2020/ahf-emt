<?php

class Dbcnx
{
    public $host = "";
    public $user = "";
    public $pass = "";
    public $db = "";
    public $myconn;

    public function __construct()
    {
        $ip = $_SERVER['REMOTE_ADDR'];

        if ($ip == '::1' || $ip == 'localhost' || $ip == "127.0.0.1") {
            $this->host = "localhost";
            $this->user = "root";
            $this->pass = "";
            $this->db = "ems_system";
        } else {
            // $this->host  = "fctevregendpoint.accessng.com";
            $this->host  = "localhost";
            $this->user = '';
            $this->pass = '';
            $this->db   = '';
        }
    }

    public function connect()
    {
        $this->myconn = new mysqli($this->host, $this->user, $this->pass, $this->db);

        /* check connection */
        if ($this->myconn->connect_error) {
            // CONNECTION FAILED WITH ERROR
            $this->connectFailed($this->myconn->connect_error);
            throw new Exception("Connection failed: " . $this->myconn->connect_error);
        }

        return $this->myconn; // This should return the connection object
    }

    public function close()
    {
        if ($this->myconn) {
            mysqli_close($this->myconn);
        }
    }

    public function connectFailed($payload)
    {
        // log payload
        $current_date = date('Y_m_d');
        $logfile = 'logger';
        if (!file_exists($logfile)) {
            mkdir($logfile);
        }
        if ($payload) {
            $payload_data = date('Y-m-d H:i:s') . " >>>> ANMFIN => ";
            $payload_data .= " [Error: " . (string)$payload . "], ";
            file_put_contents('logger/connect_debugger_' . $current_date . '.txt', $payload_data . PHP_EOL, FILE_APPEND | LOCK_EX);
        }

        header('Location: unavailable.php');
        exit;
    }
}

// END OF CLASS
