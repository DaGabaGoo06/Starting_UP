<?php
$conn = new mysqli("localhost", "root", "#rootpassword123", "startup_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>