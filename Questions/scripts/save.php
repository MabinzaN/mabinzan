 <?php
    include_once("config/db_connect.php");
    
    if(isset($_POST['send']))
    {
      $name = $_POST["name"];
      $question = $_POST["question"];
      
      $query = "INSERT INTO questions(name, question) VALUES('{$name}','{$question}')";
      $result = mysql_query($query);
    }
  ?>