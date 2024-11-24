<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "ems";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $sql = "ALTER TABLE tasks ADD COLUMN duedate DATE AFTER description";
    $conn->exec($sql);
    echo "Column 'duedate' added successfully.";
} catch (Exception $e) {
    echo "Error" . $e->getMessage();
}

return $conn;
