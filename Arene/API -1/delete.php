<?php
$url = "http://localhost/API/Arene/API-1/cars.php?id=1"; // Supprimer le produit avec l'ID 1

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

var_dump($response);

if (!$response) {
    return false;
}

curl_close($ch);

?>
