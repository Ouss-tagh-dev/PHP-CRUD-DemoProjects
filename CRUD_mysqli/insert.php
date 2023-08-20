<?php

// Including the database connection file
require_once './db.php';

// SQL template for inserting data into the 'users' table
$sql = 'INSERT INTO users(user_name, user_email, user_password) VALUES (?, ?, ?)';

// Initialize the prepared statement
$stmt = mysqli_stmt_init($conn);

// Prepare the statement
// This step checks the syntax of the SQL query
if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo 'Failed to prepare the query';
} else {
    // Values to be inserted into the database
    $user_name = 'oussama';
    $user_email = 'oussama@gmail.com';
    $user_password = 'oussama@123';

    // Bind parameters to the prepared statement
    // 'sss' indicates that all three parameters are of string type
    mysqli_stmt_bind_param(
        $stmt,
        'sss',
        $user_name,
        $user_email,
        $user_password
    );

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);
}