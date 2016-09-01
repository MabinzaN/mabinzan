<?php
	include_once("../config/db_connect.php");
	
    $query = "SELECT * FROM sms WHERE published = 1 ORDER BY id DESC";
    $result = mysql_query($query);
	//$result = mysql_query("SELECT * FROM table1", $link);
	$num_rows = mysql_num_rows($result);
	echo "$num_rows Questions\n"."</br>"."</br>";
	
    while ($questions = mysql_fetch_assoc($result))
    {
       	echo "<table width='600' cellpadding='5' cellspacing='5' border='0'>";
		$substr = strtolower(substr($questions['msg_text'], 0, 3));
		$substr2 =  strtolower(substr($questions['msg_text'], 0, 4));

		if($substr2 == "dpsa." || $substr2 == "dpsa:")
			echo "<h2><a href='#'>" . substr($questions['msg_text'], 4) . "</a></h2>" .
			"<p>" . $questions['received_time'] . " | <i class='icon-comment'></i></p>";
		elseif($substr == "dpsa")
			echo "<h2><a href='#'>" . substr($questions['msg_text'], 3) . "</a></h2>" .
			"<p>" . $questions['received_time'] . " | <i class='icon-comment'></i></p>";		
		else
			echo "<h2><a href='#'>" . $questions['msg_text'] . "</a></h2>" . 
			"<p>" . $questions['received_time'] .  " | <i class='icon-comment'></i></p>";			
    }
	
	?>