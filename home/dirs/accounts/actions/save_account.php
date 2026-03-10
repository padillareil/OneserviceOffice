<?php
	require_once "../../../../config/connection.php";
	require_once "../../../../config/functions.php";

	session_start();

	$Userid        = $_SESSION['Uid'];
	$AccountStatus = 0;
	$Type          = 'EN';

	$Fullname = $_POST['Fullname'];
	$Position = $_POST['Position'];
	$Username = $_POST['Username'];
	$Password = hash_password($_POST['Password']);

	try {

	    $conn->beginTransaction();

	    $validate_account = $conn->prepare("
	         SELECT UserName, UserFullname
	        FROM UserAccount
	        WHERE UserName = ? OR UserFullname = ?
	    ");
	    $validate_account->execute([$Username, $Fullname]);

	    if ($validate_account->fetch()) {
	        exit('This account already exist.');
	    }

	    $ins_addaccount = $conn->prepare("EXEC dbo.[CREATE_STAFF] ?,?,?,?,?,?,?");
	    $ins_addaccount->execute([
	        $Userid,
	        $Fullname,
	        $Position,
	        $Username,
	        $Password,
	        $AccountStatus,
	        $Type
	    ]);

	    $conn->commit();

	    echo "OK";

	} catch (PDOException $e) {

	    if ($conn->inTransaction()) {
	        $conn->rollBack();
	    }

	    echo "<b>Warning. Please Contact System Developer.<br/></b>" . $e->getMessage();
	}
?>