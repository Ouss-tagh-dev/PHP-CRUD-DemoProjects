<?php

// Include the database connection file
require_once './db.php';

echo PHP_EOL;  // Output a newline for clarity in the results

// SQL query template to fetch user details by user ID
$sql = 'SELECT * FROM users WHERE user_id = ?';

// Initialize the prepared statement
$stmt = mysqli_stmt_init($conn);

// Prepare the statement
// This step checks the syntax of the SQL query
if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo 'Failed to prepare the query';
} else {    
    $user_id = 1;  // Define the user ID to search for

    // Bind parameters to the prepared statement
    // 'i' indicates that the parameter is of integer type
    mysqli_stmt_bind_param($stmt, 'i', $user_id);

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Get the result of the executed statement
    $result = mysqli_stmt_get_result($stmt);

    // Loop through the results and display user details
    while ($row = mysqli_fetch_assoc($result)) {
        echo "username : " . $row['user_name'] . PHP_EOL;
        echo "email : " . $row['user_email'] . PHP_EOL;
        echo "password : " . $row['user_password'] . PHP_EOL;
    }
}

?>