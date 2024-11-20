<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
@session_start();

require_once("dbcnx.inc.php");

class Dbobject
{
    private $myconn; // Property to hold the database connection

    function __construct()
    {
        
        $dbcnx = new Dbcnx();
        $this->myconn = $dbcnx->connect(); 
        if (!$this->myconn) {
            throw new Exception('Database connection failed.');
        }
    }

    function getitemlabel($tablename, $table_col, $table_val, $ret_val) {
        $label = "";
        $table_filter = " WHERE " . $table_col . "='" . $this->myconn->real_escape_string($table_val) . "'";
    
        $query = "SELECT " . $ret_val . " FROM " . $tablename . $table_filter;
        $result = $this->myconn->query($query);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // If '*' is passed, return the full row
            if ($ret_val == '*') {
                return $row;
            }
    
            // Otherwise, return the specific field
            $label = $row[$ret_val];
        }
        
        return $label;
    }



    function selectTableData($table, $columns = '*', $conditions = '', $limit = '') {
        $columns = $this->myconn->real_escape_string($columns);
        $query = "SELECT $columns FROM $table";
    
        // Add conditions if provided
        if (!empty($conditions)) {
            $query .= " WHERE " . $conditions;  // Assumes conditions are safely escaped when passed
        }
    
        // Add limit if provided
        if (!empty($limit)) {
            $query .= " LIMIT " . $this->myconn->real_escape_string($limit);
        }
    
        // Execute the query
        $result = $this->myconn->query($query);
        $data = [];

    
    
        // Check if the query was successful
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            // Optionally handle errors
            error_log('Query Error: ' . $this->myconn->error);
        }

        return $data;
    }
    

    function insertTableData($table, $data) {
        // Escape each value, ensuring they are strings first
        $escapedValues = array_map(function($value) {
            // If the value is an array, handle it as needed (e.g., serialize or convert to a string)
            if (is_array($value)) {
                $value = json_encode($value); // Convert arrays to JSON strings
            }
            return "'" . $this->myconn->real_escape_string($value) . "'";
        }, array_values($data));
    
        $columns = implode(", ", array_keys($data));
        $values = implode(", ", $escapedValues);
    
        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        
        return $this->myconn->query($query);
    }
    

    function updateTableData($table, $data, $conditions) {
        // Validate input data
        if (empty($data) || empty($conditions)) {
            return false;  // Avoid running a query without conditions or data
        }
    
        // Build the SET part of the query
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key='" . $this->myconn->real_escape_string($value) . "'";
        }
        $setString = implode(", ", $set);
    
        // Handle WHERE conditions as an array for better flexibility
        $conditionString = [];
        foreach ($conditions as $key => $value) {
            $conditionString[] = "$key='" . $this->myconn->real_escape_string($value) . "'";
        }
        $whereClause = implode(" AND ", $conditionString);
    
        // Build and execute the query
        $query = "UPDATE $table SET $setString WHERE $whereClause";
        return $this->myconn->query($query);
    }
    

    function deleteTableData($table, $conditions) {
        $query = "DELETE FROM $table WHERE " . $this->myconn->real_escape_string($conditions);
        return $this->myconn->query($query);
    }


    // Optional: A method to close the connection when done
    function closeConnection()
    {
        if ($this->myconn) {
            $this->myconn->close();
        }
    }
}

?>
