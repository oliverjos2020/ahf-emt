<?php
require_once('dbfunctions.php');
require_once('accessClass.php');
require_once('validateionClass.php');

class InventoryClass {
    private $db;
    private $accessControl;
    private $validator;

    public function __construct() {
        $this->db = new Dbobject(); // Database interaction class
        $this->accessControl = new AccessClass(); // Handles access control based on roles
        $this->validator = new ValidationClass(); // Handles validation of input
    }

    private function jsonResponse($message = "", $code = "", $data = "") {
        // Create the response array
        $responseArray = [
            'status' => $code,
            'message' => $message,
            'data' => $data
        ];
        
        // Return the JSON-encoded response
        return $responseArray;
    }

    private function isInventoryManager($userRole) {
        // Check if user is an inventory manager
        return ($userRole === 'inventory_manager');
    }

    // Method to add new drugs to the inventory
    public function addDrugs($userData, $drugData) {
        // Check if user is an inventory manager
        if (!$this->isInventoryManager($userData['role'])) {
            return $this->jsonResponse("Unauthorized access", 403, "");
        }

        // Validate drug data
        $validate = $this->validator->validate(
            $drugData,
            array('name' => 'required', 'category' => 'required', 'quantity' => 'required|numeric'),
            array('name' => 'Drug Name', 'category' => 'Category', 'quantity' => 'Quantity')
        );

        if ($validate['error']) {
            return $this->jsonResponse("Validation failed", 400, $validate['messages']);
        }

        // Insert the drug into the inventory database
        $insert = $this->db->insertData('drug_inventory', $drugData);
        if ($insert) {
            return $this->jsonResponse("Drug added successfully", 200, $drugData);
        } else {
            return $this->jsonResponse("Failed to add drug", 500, "");
        }
    }

    // Method to view all drugs in the inventory
    public function viewDrugs($userData) {
        // Check if user is an inventory manager
        if (!$this->isInventoryManager($userData['role'])) {
            return $this->jsonResponse("Unauthorized access", 403, "");
        }

        // Fetch all drugs from the inventory
        $drugs = $this->db->selectTableData('drug_inventory', '*', '', '');
        if ($drugs) {
            return $this->jsonResponse("Drugs retrieved successfully", 200, $drugs);
        } else {
            return $this->jsonResponse("No drugs found", 404, "");
        }
    }

    // Method to edit drug details, requiring two officer approval
    public function editDrugs($userData, $drugData, $secondOfficerApproval) {
        // Check if user is an inventory manager
        if (!$this->isInventoryManager($userData['role'])) {
            return $this->jsonResponse("Unauthorized access", 403, "");
        }

        // Check if two officers have approved the edit
        if ($secondOfficerApproval !== true) {
            return $this->jsonResponse("Second officer approval required", 403, "");
        }

        // Validate drug data
        $validate = $this->validator->validate(
            $drugData,
            array('name' => 'required', 'category' => 'required', 'quantity' => 'required|numeric'),
            array('name' => 'Drug Name', 'category' => 'Category', 'quantity' => 'Quantity')
        );

        if ($validate['error']) {
            return $this->jsonResponse("Validation failed", 400, $validate['messages']);
        }

        // Update the drug information in the database
        $update = $this->db->updateData('drug_inventory', $drugData, "id='" . $drugData['id'] . "'");
        if ($update) {
            return $this->jsonResponse("Drug updated successfully", 200, $drugData);
        } else {
            return $this->jsonResponse("Failed to update drug", 500, "");
        }
    }

    // Method to manage reduction in inventory as drugs are dispensed
    public function inventoryManager($userData, $dispenseData) {
        // Check if user is an inventory manager
        if (!$this->isInventoryManager($userData['role'])) {
            return $this->jsonResponse("Unauthorized access", 403, "");
        }

        // Validate dispense data
        $validate = $this->validator->validate(
            $dispenseData,
            array('drug_id' => 'required', 'quantity' => 'required|numeric'),
            array('drug_id' => 'Drug ID', 'quantity' => 'Quantity')
        );

        if ($validate['error']) {
            return $this->jsonResponse("Validation failed", 400, $validate['messages']);
        }

        // Fetch current inventory for the drug
        $drug = $this->db->selectTableData('drug_inventory', '*', "id='" . $dispenseData['drug_id'] . "'", '');

        if ($drug) {
            // Calculate the new inventory quantity
            $newQuantity = $drug[0]['quantity'] - $dispenseData['quantity'];
            if ($newQuantity < 0) {
                return $this->jsonResponse("Insufficient stock", 400, "");
            }

            // Update the inventory
            $update = $this->db->updateData('drug_inventory', ['quantity' => $newQuantity], "id='" . $dispenseData['drug_id'] . "'");
            if ($update) {
                return $this->jsonResponse("Inventory updated successfully", 200, ['new_quantity' => $newQuantity]);
            } else {
                return $this->jsonResponse("Failed to update inventory", 500, "");
            }
        } else {
            return $this->jsonResponse("Drug not found", 404, "");
        }
    }

    // Method to fetch drug categories
    public function fetchCategories($userData) {
        // Check if user is an inventory manager
        if (!$this->isInventoryManager($userData['role'])) {
            return $this->jsonResponse("Unauthorized access", 403, "");
        }

        // Fetch drug categories from the database
        $categories = $this->db->selectTableData('drug_categories', '*', '', '');
        if ($categories) {
            return $this->jsonResponse("Categories retrieved successfully", 200, $categories);
        } else {
            return $this->jsonResponse("No categories found", 404, "");
        }
    }
}
?>
