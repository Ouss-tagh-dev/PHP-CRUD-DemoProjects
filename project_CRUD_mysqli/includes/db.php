<?php 

// Attempt to establish a connection to the MySQL database using mysqli
$link = mysqli_connect('localhost', 'root', 'root', 'db_project');

// Check if the connection was successful
if (!$link) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>