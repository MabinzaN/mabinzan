<?php
class Sms {
	private $ms_id = 0;
	
	public function get_inbox()
	{
		// Retrieve the last id from the sms table
		$this->ms_id = $this->getlastmsid();

		// Get sms from file
		$lines = file("http://bulksms.2way.co.za:5567/eapi/reception/get_inbox/1/1.1?username=intsikacorp&password=intsika&last_retrieved_id=$this->ms_id");

		// SMS variables
		$msg_id = "";
		$sender = "";
		$txt_msg = "";
		$received_time = "";
		$msisdn = "";
		$referring_batch_id = "";
		$encoding = "";		

		// Loop through the inbox
		foreach ($lines as $key => $value) {

			$record = explode("|", $value);

			// Skip record if message ID is < 8
			if(strlen($record[0]) < 8) {
				continue;
			} else {
				// an integer identifier unique to this incoming message
				if(isset($record[0]))
					$msg_id = $record[0];				
				// the number that the incoming message was sent from
				if(isset($record[1]))
					$sender = $record[1];
				// the message sent
				if(isset($record[2]))			
					$txt_msg = $record[2];
				// the time the message was received
				if(isset($record[3]))			
					$received_time = $record[3];
				// the number that the incoming message was sent to.
				if(isset($record[4]))			
					$msisdn = $record[4];
				// the integer identifier that was returned (by send_sms) at the time when the original message was submitted
				if(isset($record[5]))			
					$referring_batch_id = $record[5];											
				// 7bit/8bit/16bit.
				if(isset($record[6]))			
					$encoding = $record[6];				
			}

			$query = "INSERT INTO sms(msg_id, cell_no, msg_text, received_time, msisdn, referring_batch_id, encoding, published) VALUES($msg_id, $sender, '{$txt_msg}', '{$received_time}', $msisdn, $referring_batch_id, '{$encoding}', 0)";
			$result = mysql_query($query);

		}
	}

	public function get_questions()
	{
		// Get inbox using http relaying
		$this->get_inbox();

        $query = "SELECT * FROM sms ORDER BY id DESC";
        $result = mysql_query($query);

        while ($questions = mysql_fetch_assoc($result))
        {
        	$id = $questions['id'];
			$published = $questions['published'];
			$question_status = "hidden_sms";         	

       		$substr = strtolower(substr($questions['msg_text'], 0, 3));
			$substr2 =  strtolower(substr($questions['msg_text'], 0, 4));

			if($published == 1){
				$question_status = "";
			}

			if($substr2 == "dpsa." || $substr2 == "dpsa:")
				echo "<blockquote><p class='" . $question_status . "'>[<a href='scripts/accept.php?id=" . $id . "'>Accept</a>] [<a class='hide-action' href='scripts/hide.php?id=" . $id . "'>Hide</a>] <span class='" . $question_status . "'>" . substr($questions['msg_text'], 5) . "</span></p></blockquote>";
			elseif($substr == "dpsa")
				echo "<blockquote><p>[<a href='scripts/accept.php?id=" . $id . "'>Accept</a>] [<a class='hide-action' href='scripts/hide.php?id=" . $id . "'>Hide</a>]<span class='" . $question_status . "'> " . substr($questions['msg_text'], 4) . "</span></p></blockquote>";
			else
				echo "<blockquote><p class='" . $question_status . "'>[<a href='scripts/accept.php?id=" . $id . "'>Accept</a>] [<a class='hide-action' href='scripts/hide.php?id=" . $id . "'>Hide</a>] <span class='" . $question_status . "'>" . $questions['msg_text'] . "</span></p></blockquote>";				
        }

	}
		
	public function getlastmsid()
	{
		$query = "SELECT msg_id FROM sms ORDER BY id DESC LIMIT 1";
		$result = mysql_query($query);

		$row = mysql_fetch_array($result);
		$this->ms_id = $row[0];

		return $this->ms_id;
	}
}
?>