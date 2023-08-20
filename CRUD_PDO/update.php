<?php

// Include the database connection file
require_once('./db.php');

// SQL query template for updating user details based on a specific user ID using named placeholders
$sql = "UPDATE users SET user_name = :name, user_email = :email, user_password = :password WHERE user_id = :id";

// Prepare the SQL statement for execution
$stmt = $pdo->prepare($sql);

// Define the new user details and the user ID for the user to be updated
$name = "ouss";
$email = "ouss@gmail.com";
$password = "ouss@123";
$id = 1;

// Execute the prepared statement with the defined user details
$stmt->execute([
    ':name' => $name,
    ':email' => $email,
    ':password' => $password,
    ':id' => $id,
]);

?>