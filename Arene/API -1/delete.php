<?php
$url = "http://localhost/API/Arene/API-1/cars.php"; // URL de l'API
$id = 1; // ID du produit à supprimer

$url .= "?id=" . $id; // Ajoute l'ID à l'URL

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if ($response === false) {
    echo "Erreur de requête : " . curl_error($ch);
} else {
    echo "Réponse : " . $response;
}

curl_close($ch);
?>
