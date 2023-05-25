<?php
$server = "localhost";
$username = "root";
$password = "";
$db = "garage";
$conn = mysqli_connect($server, $username, $password, $db);

// Vérifier la connexion
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
