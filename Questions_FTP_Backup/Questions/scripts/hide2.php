<?php
	include_once("config/db_connect.php");
	$id = $_GET["id"];
	
	if(isset($_GET["type"])){
		$table = $_GET["type"];
	}else {
		$table = "sms";
	}

	$query = "UPDATE $table SET published = 0 WHERE id = '{$id}'";
	$result = mysql_query($query);

	header("Location: ../admin.php");
