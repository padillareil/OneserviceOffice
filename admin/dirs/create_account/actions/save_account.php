<?php
	require_once "../../../../config/connection.php";
	require_once "../../../../config/functions.php";

	session_start();

	if (!isset($_SESSION['Uid'])) {
	    header('Location: ../../../../login.php');
	    exit();
	}
	
	$User = $_SESSION['Uid'];
	$Fullname 		=	$_POST['Fullname'];
	$Position 		=	$_POST['Position'];
	$Username 		=	$_POST['Username'];
	$Department 	=	$_POST['Department'];
	$Password 		=	hash_password($_POST['Password']);
	$PortalID 		=	$_POST['PortalID'] ?? NULL;
	$Role 			=	'Client';

	
	try{
		$conn->beginTransaction();

		$check_error = $conn->prepare("
		  SELECT *
		  FROM user 
		  WHERE 
		  	Fullname = ?
		  	OR Username = ?
		");
		$check_error->execute([ $Fullname, $Username ]);
		$get_user = $check_error->fetch(PDO::FETCH_ASSOC);

		if ($check_error->fetch()) {
			exit('This account already exists.');
		}

		$ins_account = $conn->prepare("INSERT INTO user
			(Username, Password, Role, Position, Department, Fullname, Portal_id, Create_by)
			VALUES(?,?,?,?,?,?,?,?)");
		$ins_account->execute([$Username, $Password, $Role, $Position, $Department, $Fullname, $PortalID, $User]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact System Developer.<br/></b>".$e;getMessage();
	}


?>