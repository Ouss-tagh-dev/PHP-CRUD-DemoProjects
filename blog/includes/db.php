<?php
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASS", "root");
define("DBNAME", "db_blog");
define("PORT", "3306");
$dsn = "mysql:host=".DBHOST.";port=".PORT.";dbname=".DBNAME;
try {
    $pdo = new PDO($dsn, DBUSER, DBPASS);
} catch(PDOException $e) {
    die("ERROR:".$e->getMessage());
}
?>