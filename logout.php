<?php
ob_start();
session_start();
if(isset($_SESSION['userID'])) {
	//unset

	session_destroy();
	header("Location: index.php");
} else {
	header("Location: index.php");
}
?>