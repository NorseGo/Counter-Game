<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "registration_db";

// Tvorba connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrola connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
