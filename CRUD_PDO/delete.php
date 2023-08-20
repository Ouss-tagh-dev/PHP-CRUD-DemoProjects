<?php

// Include the database connection file
require_once('./db.php');

// SQL query template to delete a user based on a specific user ID using a named placeholder
$sql = "DELETE FROM users WHERE user_id = :id";

// Prepare the SQL statement for execution
$stmt = $pdo->prepare($sql);

// Define the user ID for the user to be deleted
$id = 1;

// Execute the prepared statement with the defined user ID
$stmt->execute([
    ':id' => $id,
]);

?>