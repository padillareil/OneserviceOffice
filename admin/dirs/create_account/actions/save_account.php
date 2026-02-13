<?php
	require_once "../../../../config/connection.php";
	require_once "../../../../config/functions.php";

	session_start();

	if (!isset($_SESSION['Uid'])) {
	    header('Location: ../../../../login.php');
	    exit();
	}
	
	$User			= $_SESSION['Uid'];
	$Fullname 		=	$_POST['Fullname'];
	$Position 		=	$_POST['Position'];
	$Username 		=	$_POST['Username'];
	$Password 		=	hash_password($_POST['Password']);
	$Role 			=	$_POST['Role'];
	$Department 	=	$_POST['Department'];
	$Branch 		=	$_POST['Branch'];
	$AccountStatus 	=	0; /*Meaning Active*/
	$AccountMode 	=	0; /*Meaning New*/
	$AccountAccess 	=	1; /*Meaning Enabled if 0 then blocked*/
	
	$AccountType = '';

	if ($Role === '2') {
	    $AccountType = 'EN/APP';
	} elseif ($Role === '3') {
	    $AccountType = 'EN';
	} elseif ($Role === '4') {
	    $AccountType = 'CKR';
	} else {
	    $AccountType = 'SA';
	}
	
	try {
	    $conn->beginTransaction();

	    /* Duplicate check */
	    $check_error = $conn->prepare("
	        SELECT 1
	        FROM UserAccount
	        WHERE UserFullname = ?
	           OR UserName = ?
	    ");
	    $check_error->execute([$Fullname, $Username]);

	    if ($check_error->fetch()) {
	        $conn->rollback();
	        exit('This account already exists.');
	    }

	    /* Get Region from Branch */
	    $get_region = $conn->prepare("EXEC dbo.[IAPREGION] ?");
	    $get_region->execute([$Branch]);
	    $regionRow = $get_region->fetch(PDO::FETCH_ASSOC);

	    if (!$regionRow) {
	        $conn->rollback();
	        exit('Invalid branch selected.');
	    }

	    $Region = $regionRow['Region'];

	    /* Insert account */
	    $ins_account = $conn->prepare("
	        INSERT INTO UserAccount
	        (UserName, UserPassword, Role, UserJobPosition, UserDepartment,
	         UserFullname, BranchAssignment, BranchRegion, AccountStatus, AccountMode, AccountType,AccountAccess)
	        VALUES (?,?,?,?,?,?,?,?,?,?,?,?)
	    ");

	    $ins_account->execute([
	        $Username,
	        $Password,
	        $Role,
	        $Position,
	        $Department,
	        $Fullname,
	        $Branch,
	        $Region,
	        $AccountStatus,
	        $AccountMode,
	        $AccountType,
	        $AccountAccess
	    ]);

	    $conn->commit();
	    echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact System Developer.<br/></b>".$e;getMessage();
	}


?>