<?php
$server = "db4free.net";
$username = "root";
$password = "devarenetest1";
$db = "garage";
$conn = mysqli_connect($server, $username, $password, $db);

// Vérifier la connexion
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
