<?php

// Include the database connection file
require_once './db.php';

// SQL query template to update user details based on user ID
$sql = 'UPDATE users SET `user_name` = ?, `user_email` = ?, `user_password` = ? WHERE user_id = ?';

// Initialize the prepared statement
$stmt = mysqli_stmt_init($conn);

// Prepare the statement
// This step checks the syntax of the SQL query
if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo 'Failed to prepare the query';
} else {
    
    // Define the new user details and the user ID to update
    $user_name = 'ouss';
    $user_email = 'ouss@gmail.com';
    $user_password = 'ouss@123';
    $user_id = 1;
    
    // Bind parameters to the prepared statement
    // 'sssi' indicates that the first three parameters are of string type, and the fourth is of integer type
    mysqli_stmt_bind_param(
        $stmt,
        'sssi',
        $user_name,
        $user_email,
        $user_password,
        $user_id
    );

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);
}

?>