<?php
$host = '';
$use = '';
$pas = '';
$db = '';

$conn = new mysqli($host, $use, $pas, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
