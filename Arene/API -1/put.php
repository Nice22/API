<?php
$url = "http://localhost/API/Arene/API -1/put.php"; // Modifier l'URL selon vos besoins
$data = array('name' => 'MAC', 'description' => 'Ordinateur portable', 'price' => '9658', 'category' => '2');

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

$response = curl_exec($ch);

var_dump($response);

if (!$response) {
    return false;
}
?>
