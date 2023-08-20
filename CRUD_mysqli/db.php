<?php
// Attempt to establish a connection to the MySQL database using mysqli
$conn = mysqli_connect('localhost', 'root', 'root', 'db_project');

// Check if the connection was successful
if ($conn) {
    echo "Connected";
}

?>