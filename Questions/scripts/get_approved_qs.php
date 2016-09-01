<?php
	include_once("config/db_connect.php");
	
	$query = "SELECT * FROM questions WHERE published = 1 ORDER BY id DESC";
	$result = mysql_query($query);
	
	$num_rows = mysql_num_rows($result);
	
	while($questions = mysql_fetch_assoc($result)){
			//echo "<h3><a href='#'>" . $questions['question'] . "</a></h3>" . 
			//"<h5>" . $questions['time'] .  " | <i class='icon-comment'></i></h5>";	
			echo "<blockquote class='bg-success'>". $questions['question'] ."</blockquote>";	
			echo "<footer>" . $questions['time'] .  " | <i class='icon-comment'></i></footer>";	
			echo "&nbsp;";
	}
	
	if($num_rows <= 0){
		echo "<p><a href='#'>(There's Currently No questions)</a></p>";
	}