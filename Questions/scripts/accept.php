<?php
	include_once("config/db_connect.php");
	$id = $_GET["id"];
	
	if(isset($_GET["type"])){
		$table = $_GET["type"];
		//$table = "sms";
	}else {
		$table = "sms";
	}	

	$query = "UPDATE $table SET published = 1 WHERE id = '{$id}'";
	$result = mysql_query($query);
	
	if(isset($_GET["type"])){
		header("Location: ../admin.php");
	}else {
		header("Location: ../admin.php");
	}	

	
