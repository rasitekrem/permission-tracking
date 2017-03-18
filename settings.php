<?php
	include("connect.php");

	if(!isset($_SESSION['ID']))
	{
		echo location(0, "index.php");
	}
	else
	{
		$stmt=$db->prepare("select * from systemTable where USERNAME=?");
		$stmt->bindParam(1,$_SESSION['ID']);
		$stmt->execute();
		$password=$db->prepare("select * from users where USERNAME=?");
		$password->bindParam(1,$_SESSION['ID']);
		$password->execute();
									$stmt=$stmt->fetch(PDO::FETCH_ASSOC);
									$password=$password->fetch(PDO::FETCH_ASSOC);
?>

<html>

	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>

	<body>
		<div class="body"></div>
		<div class="grad"></div>
		<div class="welcome"><div>Welcome <span><?php echo htmlspecialchars($username,ENT_QUOTES);?></span> </div></div>
			<div class="container">
				<form action="settings.php" method="POST">
													<input type="submit" value="Save" name="save">
													<input type="submit" value="Only Change Phone Number" name="number">
													<input type="submit" value="Back" name="back">
						<table>
								<tr>
									<td>Old Password</td>
									<td><input type="password"  name="oldpass"></td>
								</tr>
								<tr>
									<td>New Password</td>
									<td><input type="password"  name="newpass"></td>
								</tr>
								<tr>
									<td>New Password Again</td>
									<td><input type="password"  name="newpassagain"></td>

								</tr>
								<tr>
									<td>Mobile Phone Number</td>
									 <?php echo '<td><input type="text" value="'.htmlspecialchars($stmt['PHONE_NO'],ENT_QUOTES).'"  name="mobile" ></td>';?>

								</tr>
						</table>

				</form>


<?php
	}

	if($_POST)
	{
		if(isset($_POST['back']))
		{
			if(htmlspecialchars($_SESSION['ID'],ENT_QUOTES)=="admin")
			{
				echo location(0,"admin.php");
			}
			else echo location(0, "login.php");
		}
		else if(isset($_POST['number']))
		{
			$update=$db->prepare("update systemTable set PHONE_NO=? where USERNAME=?");
			$update->bindParam(1,$_POST['mobile']);
			$update->bindParam(2,$_SESSION['ID']);
			$update->execute();
						if($update)
							echo '<div class="setting" >Mobile Phone Number changed.</div> ';
						else
							echo '<div class="setting" >Change Failed</div> ';
		}

		else if(isset($_POST['save']))
		{
			if(empty($_POST['oldpass']) || empty($_POST['newpass']) || empty($_POST['newpassagain']) || empty($_POST['mobile']))
			{
				echo '<div class="setting" >Missing Information</div> ';
			}
			else
			{
				if($_POST['oldpass']==$password['PASSWORD'])
				{
					if($_POST['newpass']==$_POST['newpassagain'])
					{
						$updateProfile=$db->prepare("update users set PASSWORD=:? where USERNAME=?");
						$updateProfile->bindParam(1,$_POST['newpass']);
						$updateProfile->bindParam(2,$_SESSION['ID']);
						$updateNumber=$db->prepare("update systemTable set PHONE_NO=:mobile where USERNAME=?");
						$updateNumber->bindParam(1,$_POST['mobile']);
						$updateNumber->bindParam(2,$_SESSION['ID']);
						$updateNumber->execute();
						$updateProfile->execute();
						if($updateProfile && $updateNumber)
							echo '<div class="setting" >Update Successfully</div> ';
						else
							echo '<div class="setting" >Update Failed</div> ';
					}
					else
							echo '<div class="setting" >New Passwords Are Different.</div> ';
				}
				else
				{

							echo '<div class="setting" >Wrong Old Password</div> ';
				}
			}
		}
		else{
				echo '<div class="setting" >Wrong Process</div>';
		}
	}
?>
</div>

	</body>

</html>
