<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to database
include("connect.php");
$request_method = $_SERVER["REQUEST_METHOD"];

function getCars($order_by)
{
    global $conn;
    $query = "SELECT cars.*, modele.name AS modele_name, marque.name AS marque_name 
              FROM cars 
              LEFT JOIN modele ON cars.modele_id = modele.id 
              LEFT JOIN marque ON cars.marque_id = marque.id 
              ORDER BY $order_by";
    $response = array();
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function addCar()
{
    global $conn;
    $data = json_decode(file_get_contents('php://input'), true);
    $modele_id = $data["modele_id"];
    $marque_id = $data["marque_id"];
    $designation = $data["designation"];
    $price = $data["price"];
    $color = $data["color"];
    $year = $data["year"];

    $query = "INSERT INTO cars (modele_id, marque_id, designation, price, color, year) 
              VALUES ('$modele_id', '$marque_id', '$designation', '$price', '$color', '$year')";

    if (mysqli_query($conn, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Car added successfully.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'Failed to add car. ' . mysqli_error($conn)
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function updateCar($id)
{
    global $conn;
    $data = json_decode(file_get_contents('php://input'), true);
    $modele_id = $data["modele_id"];
    $marque_id = $data["marque_id"];
    $designation = $data["designation"];
    $price = $data["price"];
    $color = $data["color"];
    $year = $data["year"];

    $query = "UPDATE cars SET 
              modele_id = '$modele_id', 
              marque_id = '$marque_id', 
              designation = '$designation', 
              price = '$price', 
              color = '$color', 
              year = '$year' 
              WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Car updated successfully.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'Failed to update car. ' . mysqli_error($conn)
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function deleteCar($id)
{
    global $conn;
    $query = "DELETE FROM cars WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Car deleted successfully.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'Failed to delete car. ' . mysqli_error($conn)
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

switch ($request_method) {

    case 'GET':
        // Retrieve Cars
        if (!empty($_GET["order_by"])) {
            $order_by = $_GET["order_by"];
            getCars($order_by);
        } else {
            getCars("car_name"); // Par défaut, triez par le nom de la voiture
        }
        break;

    case 'POST':
        // Add a new car
        addCar();
        break;

    case 'PUT':
        // Update a car
        $id = intval($_GET["id"]);
        updateCar($id);
        break;

    case 'DELETE':
        // Delete a car
        $id = intval($_GET["id"]);
        deleteCar($id);
        break;

    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
?>
