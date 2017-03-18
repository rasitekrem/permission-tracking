<?php
## DATABASE CONNECTION ##
include("connect.php");
## SESSION CONTROL ##
## Normal user can not enter ##

if(isset($_SESSION['ID']))
{
	if(htmlspecialchars($_SESSION['ID'],ENT_QUOTES)!="admin")
	{
		echo location(0,"login.php");
	}

	else ## IF YOU AN AUTHORIZED USER, YOU CAN NOT SEE SOURCE CODE. ##
	{

?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
<div class="body"></div>
	<div class="welcome"><div>Welcome <span><?php echo htmlspecialchars($username,ENT_QUOTES); ?></span> </div></div>
		<div class="grad"></div>
	<div class="admin">
		<!--Admin Panel List -->
	<form action="admin.php" method="POST">
		<div class="buton">
		<input type="submit" value="Personnel Add" name="add"><br>
		<input type="submit" value="Permission Verify List" name="verify"><br>
		<input type="submit" value="Personnel List" name="list"><br>
		<input type="submit" value="Account Settings" name="settings"><br>
		<input type="submit" value="Logout" name="logout">
		</div>
	</form>
	</div>
</body>
</html>
<?php
	}
}
	else echo location(0,"index.php");

?>
<?php
	if($_POST)
	{
		if(isset($_POST['logout']))
		{
			session_destroy();
			echo location(1,"index.php");
		}
		else if(isset($_POST['add']))
		{
			echo location(0,"add.php");
		}
		else if(isset($_POST['list']))
		{
			echo location(0, "list.php");
		}
		else if(isset($_POST['settings']))
		{
			echo location(0, "settings.php");
		}
		elseif(isset($_POST['verify']))
		{
			echo location(0, "permission_verify.php");
		}
	}
?>
