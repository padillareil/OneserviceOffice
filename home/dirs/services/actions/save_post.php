<?php
	require_once "../../../../config/connection.php";
	session_start();
	$User = $_SESSION['Uid'];

	if (!isset($_SESSION['Uid'])) {
	    header('Location: ../../../../login.php');
	    exit();
	}


	$fetch_user = $conn->prepare("CALL SESSIONUSER(?)");
    $fetch_user->execute([$User]);
    $get_user = $fetch_user->fetch(PDO::FETCH_ASSOC);
    $fetch_user->closeCursor();



    $Department 	= $get_user['Department'] ?? null;
	$Service 		=	$_POST['Service'];
	$Type 			=	$_POST['Type'];
	$Availability 	=	$_POST['Availability'];
	$Start 			=	$_POST['Start'];
	$End 			=	$_POST['End'];
	$Description 	=	$_POST['Description'];
	$Control 		=	$_POST['Control'];
		
	try{

		$conn->beginTransaction();

		$ins_service = $conn->prepare("CALL POST_SERVICE (?,?,?,?,?,?,?,?, ?)");
		$ins_service->execute([$Service, $Type, $Availability, $Start, $End, $Description, $User, $Department, $Control]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact System Developer.<br/></b>".$e;getMessage();
	}


?>
