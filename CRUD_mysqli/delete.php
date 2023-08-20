<?php

// Including the database connection file
require_once './db.php';

// Step 1: Define the SQL template
$sql = 'DELETE FROM users WHERE user_id = ?';

// Step 2: Initialize the prepared statement
$stmt = mysqli_stmt_init($conn);

// Step 3: Prepare the statement
// This step checks the SQL query's syntax
if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo 'Failed to prepare the query';
} else {
    // User ID to be deleted
    $user_id = 1;
    
    // Step 4: Bind parameters to the prepared statement
    // 'i' signifies that the parameter is of integer type
    mysqli_stmt_bind_param(
        $stmt,
        'i',
        $user_id
    );

    // Step 5: Execute the prepared statement
    mysqli_stmt_execute($stmt);
}