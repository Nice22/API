<?php
// Connect to database
include("connect.php");
$request_method = $_SERVER["REQUEST_METHOD"];

function getCars()
{
    global $conn;
    $query = "SELECT * FROM cars ORDER BY car_name";
    $response = array();
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function getCar($id)
{
    global $conn;
    $query = "SELECT * FROM cars WHERE id = $id";
    $response = array();
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $response = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function addCar()
{
    global $conn;
    $data = json_decode(file_get_contents('php://input'), true);
    $car_name = $data["car_name"];
    $modele_id = $data["modele_id"];
    $marque_id = $data["marque_id"];
    $designation = $data["designation"];
    $price = $data["price"];
    $color = $data["color"];
    $year = $data["year"];

    $query = "INSERT INTO cars (car_name, modele_id, marque_id, designation, price, color, year) 
              VALUES ('$car_name', '$modele_id', '$marque_id', '$designation', '$price', '$color', '$year')";

    if (mysqli_query($conn, $query)) {
        $car_id = mysqli_insert_id($conn);
        $response = array(
            'status' => 1,
            'status_message' => 'Car added successfully.',
            'car_id' => $car_id
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
    $car_name = $data["car_name"];
    $modele_id = $data["modele_id"];
    $marque_id = $data["marque_id"];
    $designation = $data["designation"];
    $price = $data["price"];
    $color = $data["color"];
    $year = $data["year"];

    $query = "UPDATE cars SET 
              car_name = '$car_name', 
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
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            getCar($id);
        } else {
            getCars();
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
