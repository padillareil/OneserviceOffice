<?php
	require_once "../../../../config/connection.php";
	require_once "../../../../config/functions.php";

	session_start();
	$Userid			= 	$_SESSION['Uid'];

	$fetch_mother = $conn->prepare("EXEC dbo.[SESSION_USERACCOUNT] ?");
	$fetch_mother->execute([ $Userid ]);
	$mother = $fetch_mother->fetch(PDO::FETCH_ASSOC);

	$Department		= $mother['UserDepartment'];
	$Branch			= $mother['BranchAssignment'];
	$Region			= $mother['BranchRegion'];
	$Landline		= $mother['Landline'];
	$Mobile			= $mother['MobileNumber'];
	$AccountStatus	= 0;
	$Type			= 'EN';
	$Fullname 		=	$_POST['Fullname'];
	$Position 		=	$_POST['Position'];
	$Username 		=	$_POST['Username'];
	$Password 		=	hash_password($_POST['Password']);
	
	try{

		$conn->beginTransaction();

		$ins_addaccount = $conn->prepare("INSERT INTO UserAccount
			(
				UserFullname, 
				UserJobPosition,
				UserDepartment, 
				BranchAssignment, 
				BranchRegion, 
				AccountStatus, 
				AccountMode, 
				AccountType,
				UserName,
				UserPassword,
				Landline,
				MobileNumber
				)VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
		$ins_addaccount->execute([
			$Fullname,
			$Position, 
			$Department, 
			$Branch,
			$Region,
			$AccountStatus,
			$AccountStatus,
			$Type,
			$Username,
			$Password,
			$Landline,
			$Mobile

		]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact System Developer.<br/></b>".$e;getMessage();
	}


?>
