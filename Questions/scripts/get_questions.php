<?php
	include_once("config/db_connect.php");
	
    $query = "SELECT * FROM questions ORDER BY id DESC";
    $result = mysql_query($query);
	
    while ($questions = mysql_fetch_assoc($result))
    {
		$question_status = "hidden_sms";
		
	    $id = $questions['id'];
		$published = $questions['published'];
		$question_status = "hidden_sms";    	
		
		if($published == 1){
			$question_status = "";
		}
	
		
		echo "<blockquote class='bg-success'><p class='" . $question_status . "'> <a href='scripts/accept.php?id=" . $id . "&type=questions'>Accept</a> | <a class='hide-action' href='scripts/hide2.php?id=" . $id . "&type=questions'>Hide</a> : <span class='" . $question_status . "'>" . $questions['question'] . "</span></p></blockquote>";
	}