<?php
	session_start();
	$name = $password = "";
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$user = test_input($_POST["user"]);
		$password = hash("sha256", $_POST["password"]);
		$conn = new mysqli('localhost', 'root', 'hacking', 'Cestero_test'); 
		if($conn->connect_error){
			die("Connection failed: " . $conn->connect_error);
		}
		$sql = "SELECT Password FROM Usuarios WHERE Username='".$user ."'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			$passwordRow = $result->fetch_assoc();
			$myHashPass = $passwordRow['Password'];
			if($myHashPass == $password){
				$_SESSION['Username'] = $name;
				$_SESSION['Password'] = $myHashPass;
				if($user == "Cestero") redirect("hub_boss.php");
				else redirect("hub.php");
			}
		}
	}

	function redirect($url){
		ob_start();
		header('Location: '.$url);
		ob_end_flush();
		die();
	}
	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		return htmlspecialchars($data);
	}
?>