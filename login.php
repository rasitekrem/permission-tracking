<?php
include("connect.php");
if(isset($_SESSION['ID']))
{
	if(htmlspecialchars($_SESSION['ID'],ENT_QUOTES)=="admin")
	{
		echo location(0,"admin.php");
	}
	else
	{

?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
	<div class="body"></div>
		<div class="grad"></div>
		<div class="welcome"><div>Welcome <span><?php echo htmlspecialchars($username,ENT_QUOTES);?></span> </div></div>
	<div class="admin">
		<form action="login.php" method="POST">
		<div class="buton">
			<!-- Personel Panel -->
		<input type="submit" value="Permission Information" name="permission"><br>
		<input type="submit" value="Account Settings" name="settings"><br>
		<input type="submit" value="Logout" name="logout">
		</div>
	</form>
</body>
</html>
<?php
	}
}
else echo location(0, "index.php");
?>

<?php
		if($_POST)
	{
		if(isset($_POST['logout']))
		{
			session_destroy();
			echo location(1,"index.php");
		}
		else if(isset($_POST['settings']))
		{
			echo location(0, "settings.php");
		}
		else if(isset($_POST['permission']))
		{
			echo location(0, "permission.php");
		}

	}
?>
