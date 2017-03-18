<?php

include("connect.php");

date_default_timezone_set('Europe/Istanbul');
$system_date=date("Y-m-d");
$stmt = $db->prepare("select * from systemTable where PERMISSION_STATUS='Permitted'");
$stmt->execute();
if($stmt)
{
	##permission day over##
	while($array = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$difference=strtotime($array['PERMISSION_END'])-strtotime($system_date);

		if($difference<0)
		{

			$stmt = $db->prepare("update systemTable set PERMISSION_STATUS='Working',PERMISSION_START=NULL,PERMISSION_END=NULL where USERNAME=?");
			$stmt->bindParam(1,$array['USERNAME']);
			$stmt->execute();
			$stmt = $db->prepare("update permissionControl set PERMISSION_APPROVAL='Perm Time Done' where USERNAME=? and PERMISSION_APPROVAL='Permitted'");
			$stmt->bindParam(1,$array['USERNAME']);
			$stmt->execute();
		}

	}
}

if(isset($_SESSION['ID']))
{

	if(htmlspecialchars($_SESSION['ID'],ENT_QUOTES)=="admin")
	{
		echo location(2,"admin.php");
	}
	else
		echo location(0, "login.php");
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<div class="body"></div>
		<div class="grad"></div>
		<div class="header">
			<div>Personnel<span>Permisson</span>
					Tracking<span>System</span></div>
		</div>
		<br><form action="index.php" method="POST">
		<div class="login">

				<input type="text" placeholder="Username" name="username"><br>
				<input type="password" placeholder="Password" name="password"><br>
				<input type="submit" value="Login" name="login">

		</div></form>
	</body>
</html>
<?php
	if($_POST)
	{
		if(isset($_POST['login']))
		{
			if(empty($_POST['username']) || empty($_POST['password']))
			{
				echo '<div class="alert"> <div class="login">Username or Password not entered...</div></div>';
			}
			else
			{
				$stmt=$db->prepare("select * from users where USERNAME=?");
				$stmt->bindValue(1,$_POST['username']);
				$stmt->execute();
				$fetch=$stmt->fetch(PDO::FETCH_ASSOC);
				if($_POST['password']==$fetch['PASSWORD'])
				{

						echo '<div class="alert"><div class="login"> Login Successfully . You Are Redirecting Now...</div> </div>';
						$_SESSION['ID']=$_POST['username'];
						//echo location(2, "login.php");
						 echo location(2,"login.php");

				}
				else
				{
						 echo '<div class="alert"><div class="login">Wrong Username or Password. Please Try Again..</div> </div>';
				}
			}
		}
	}
?>
