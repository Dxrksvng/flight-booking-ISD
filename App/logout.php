<?php
	session_start();

	unset($_SESSION['authenticated']);
	unset($_SESSION['role']);
	unset($_SESSION['booking']);
	unset($_SESSION['user_id']);
	$_SESSION['status'] = "ออกจากระบบสำเร็จ";
	header("location: login.php");

?>
