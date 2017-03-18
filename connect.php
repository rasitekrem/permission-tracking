<?php


	try
	{
		$host 	= "localhost";
		$user		= "root";
		$pass 	= "";
		$dbname = "personnel";



		$db 		= new PDO("mysql:host=$host;dbname=$dbname", $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
	}
	catch (PDOException $e)
	{
    echo "Error!: " . $e->getMessage() . "<br/>";
    die();
	}
	session_start();
	function location($time,$page){
  		$res = "<meta http-equiv=\"refresh\" content=\"$time;url=$page\">\n";
  		return $res;
 		}
	if(isset($_SESSION['ID']))
	{
	 	$stmt = $db->prepare("SELECT NAME,SURNAME FROM systemTable WHERE USERNAME = ?");
		$stmt->bindParam(1,$_SESSION['ID']);
		if($stmt->execute())
		{
			$username= $stmt->fetch(PDO::FETCH_ASSOC);
			$username= $username['NAME'].' '.$username['SURNAME'];
			## For 'Welcome ... ' Header ##
		}
		else
		{
			print_r($stmt->errorInfo());
		}
	}
?>
