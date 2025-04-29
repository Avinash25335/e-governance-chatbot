<?php
$host = "localhost";
$user = "root";       // XAMPP default user
$pass = "";           // XAMPP default password is empty
$db = "egov_chatbot";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>