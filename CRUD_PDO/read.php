<?php

// Include the database connection file
require_once('./db.php');
/*
// SQL query template to fetch user details based on user ID and user name using named placeholders
$sql = "SELECT * FROM users WHERE user_id = :userId AND user_name = :userName";

// Prepare the SQL statement for execution
$stmt = $pdo->prepare($sql);

// Define the values for the named placeholders
$userId = 1;
$userName = 'oussama';

// There are two ways to bind the values to the named placeholders:

// 1. Using bindParam method (this part is commented out):
/*
$stmt->bindParam(':userId', $userId);
$stmt->bindParam(':userName', $userName);
$stmt->execute();
*/
/*
// 2. Passing an associative array to the execute method:
$stmt->execute([
    ':userId' => $userId,
    ':userName' => $userName,
]);

// Fetch the results and print them
while ($users = $stmt->fetch()) {
    print_r($users);
}
*/

// SQL query template to fetch all user details
$sqlAllUsers = "SELECT * FROM users";

// Prepare the SQL statement for execution
$stmtAllUsers = $pdo->prepare($sqlAllUsers);

// Execute the prepared statement
$stmtAllUsers->execute();

// Fetch the results and print them
while ($allUsers = $stmtAllUsers->fetch()) {
print_r($allUsers);
}
?>