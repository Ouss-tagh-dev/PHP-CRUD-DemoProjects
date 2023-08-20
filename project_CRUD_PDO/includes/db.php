<?php

// Database configuration constants
define("DBHOST", "localhost");  // Database host
define("DBUSER", "root");       // Database user
define("DBPASS", "root");       // Database password
define("DBNAME", "db_project"); // Database name
define("PORT", "3306");         // Database port

// Construct the Data Source Name (DSN) for PDO connection
$dsn = "mysql:host=" . DBHOST . ";port=" . PORT . ";dbname=" . DBNAME;

// Attempt to establish a connection using PDO
try {
    $pdo = new PDO($dsn, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Optional: Set error reporting to exceptions
} catch(PDOException $e) {
    // If the connection fails, terminate the script and display the error message
    die("Connection failed: " . $e->getMessage());
}

?>