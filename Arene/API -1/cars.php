<?php
	// Connect to database
	include("connect.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getCars()
	{
		global $conn;
		$query = "SELECT * FROM car";
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result))
		{
			$response[] = $row;
		}
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	
	function getCar($id=0)
	{
		global $conn;
		$query = "SELECT * FROM car";
		if($id != 0)
		{
			$query .= " WHERE id=".$id." LIMIT 1";
		}
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result))
		{
			$response[] = $row;
		}
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	
	function AddCar()
	{
		global $conn;
		$type = $_POST["type"];
		$licensePlate = $_POST["licensePlate"];
		$color = $_POST["color"];
		$category = $_POST["category"];
		$year = $_POST["year"];
		$brand = $_POST["brand"];
		$created = date('Y-m-d H:i:s');
		//$modified = date('Y-m-d H:i:s');
		$query = "INSERT INTO car (type, licensePlate, color, category_id, year, brand, created) VALUES ('$type', '$licensePlate', '$color', '$category', '$year', '$brand', '$created')";

		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Car add successfully.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'ERREUR!.'. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	function updateCar($id)
	{
		global $conn;
		$_PUT = array();
		parse_str(file_get_contents('php://input'), $_PUT);
		$type = $_PUT["type"];
		$licensePlate = $_PUT["licensePlate"];
		$color = $_PUT["color"];
		$category = $_PUT["category"];
		$year = $_PUT["year"];
		$brand = $_PUT["brand"];
		
		$created = 'NULL';
		//$modified = date('Y-m-d H:i:s');
		$query = "UPDATE car SET type='$type', licensePlate='$licensePlate', color='$color', category_id='$category', year='$year', brand='$brand' WHERE id=$id";

		
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Car update successfully.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Echec of the update. '. mysqli_error($conn)
			);
			
		}
		
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	function deleteCar($id)
	{
		global $conn;
		$query = "DELETE FROM produit WHERE id=".$id;
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Car deleted successfully.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>"Une erreur s'est produite lors de l'exécution de la requête.". mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	switch($request_method)
	{
		
		case 'GET':
			// Retrive Products
			if(!empty($_GET["id"]))
			{
				$id=intval($_GET["id"]);
				getCar($id);
			}
			else
			{
				getCars();
			}
			break;
		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
			
		case 'POST':
			// Ajouter un produit
			AddCar();
			break;
			
		case 'PUT':
			// Modifier un produit
			$id = intval($_GET["id"]);
			updateCar($id);
			break;
			
		case 'DELETE':
			// Supprimer un produit
			$id = intval($_GET["id"]);
			deleteCar($id);
			break;

	}
?>