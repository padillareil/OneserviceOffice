<?php
	require_once "../../../../config/connection.php";
	session_start();
	$User = $_SESSION['Uid'];

	if (!isset($_SESSION['Uid'])) {
	    header('Location: ../../../../login.php');
	    exit();
	}


	$fetch_user = $conn->prepare("EXEC dbo.[SESSION_USERACCOUNT] ?");
    $fetch_user->execute([$User]);
    $get_user = $fetch_user->fetch(PDO::FETCH_ASSOC);
    $fetch_user->closeCursor();



    $Department 	= $get_user['UserDepartment'] ?? null;
	$Title 			=	$_POST['Title'];
	$Category 		=	$_POST['Category'];
	$Description 	=	$_POST['Description'];
	$Status 		=	1;
	$Publication 	=	'PB';
		
	try{

		$conn->beginTransaction();

		$ins_service = $conn->prepare("EXEC dbo.[POST_SERVICE] ?,?,?,?,?,?,?");
		$ins_service->execute([$Department, $Title, $Category, $User, $Status, $Description, $Publication]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact System Developer.<br/></b>".$e;getMessage();
	}


?>


