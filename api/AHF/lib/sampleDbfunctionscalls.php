<?php 

$db = new Dbobject();

// Select example
$users = $db->select('users', '*', 'status="active"', '10');

// Insert example
$newUser = ['username' => 'john_doe', 'email' => 'john@example.com'];
$db->insert('users', $newUser);

// Update example
$db->update('users', ['email' => 'john.doe@example.com'], 'username="john_doe"');

// Delete example
$db->delete('users', 'username="john_doe"');

// Close connection when done
$db->closeConnection();
