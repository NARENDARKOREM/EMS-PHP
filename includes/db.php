<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "ems";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Database Connected Successfully...<br>"; // Debugging output
} catch (Exception $e) {
    echo "Error" . $e->getMessage();
}

return $conn;
