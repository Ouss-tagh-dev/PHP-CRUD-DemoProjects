<?php

// Include the database connection file
require_once('./db.php');

// SQL query template for inserting user data
$sql = "INSERT INTO users(user_name, user_email, user_password) VALUES(:name, :email, :password)";

// Prepare the SQL statement for execution
$stmt = $pdo->prepare($sql);

// Define user data to be inserted
$name = "Oussama";
$email = "oussama@gmail.com";
$password = "Oussama@123";

// Execute the prepared statement with the defined user data
$stmt->execute(
    [
        ':name' => $name,
        ':email' => $email,
        ':password' => $password,
    ]
);

?>