<?php

	include("connect.php");
	if(isset($_SESSION['ID']))
	{
			if(htmlspecialchars($_SESSION['ID'],ENT_QUOTES)=="admin"){
				echo location(0, "permission_verify.php");
			}
			else
			{
			$result=$db->prepare("select PERMISSION_DAY,PERMISSION_STATUS,DEPARTMENT from systemTable where USERNAME=?");
			$result->bindParam(1,$_SESSION['ID']);
			$result->execute();
			$stmt=$result->fetch(PDO::FETCH_ASSOC);
			$depWorking=$db->prepare("select Count(*) as sayi from systemTable where DEPARTMENT=? and PERMISSION_STATUS='Working'");
			$depWorking->bindParam(1,$stmt['DEPARTMENT']);
			$depWorking->execute();
			$depWorking=$depWorking->fetch(PDO::FETCH_ASSOC);
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>

	<body>
		<div class="body"></div>
		<div class="grad"></div>
		<div class="welcome"><div>Welcome <span><?php echo htmlspecialchars($username,ENT_QUOTES); ?></span> </div></div>
		<div class="addform">
			<div class="izin">
			<form action="permission.php" method="POST">
			<input type="text" value="Permission First Day" disabled>
			<?php
					date_default_timezone_set('Europe/Istanbul');
					$date = date('Y-m-d');
			 ?>
			<input type="date" name="dateout" min="<?php echo $date; ?>"> <!-- Default time min -->
			<input type="text" value="Permission End Day" disabled><br>
			<input type="date" name="datein" min="<?php echo $date; ?>"><br> <!-- Default time min -->
			<input type="submit" value="Save" name="save">
			<input type="submit" value="Permission Documents" name="list">
			<input type="submit" value="Back" name="back">
			</form>
		</div>

<?php
			if($_POST)
			{

				if(isset($_POST['save']))
				{
					if($depWorking['sayi']<2)
					{
						echo '<div class="alert"><div class="add_permission" >You are the only one working in that department right now, so you can not get permission. </div> </div>';
					}
					elseif($stmt['PERMISSION_STATUS']=="Working")
					{
						if(strtotime($_POST['dateout'])>strtotime($_POST['datein']))
						{
							echo '<div class="alert"><div class="add_permission" >Choice error. Try Check Again...</div> </div>';
						}
						else if(strtotime($_POST['dateout'])<strtotime(date("Y-m-d")))
						{
							echo '<div class="alert"><div class="add_permission" >Past time error... </div> </div>';
						}

						else
						{
							$time=strtotime($_POST['datein'])-strtotime($_POST['dateout']);
							$time=$time/(3600*24);
							if($stmt['PERMISSION_DAY']>=$time)
							{
								$newPermission=$stmt['PERMISSION_DAY']-$time;
								$result = $db->prepare("INSERT INTO permissionControl (USERNAME,PERMISSION_START,PERMISSION_END,PERMISSION_DAY,NEW_PERMISSION_DAY)
																		VALUES(?,?,?,?,?)");
								$result->bindParam(1,$_SESSION['ID']);
								$result->bindParam(2,$_POST['dateout']);
								$result->bindParam(3,$_POST['datein']);
								$result->bindParam(4,$time);
								$result->bindParam(5,$newPermission);
								$result->execute();
								$result = $db->prepare("update systemTable set PERMISSION_STATUS='Approval Waiting' where USERNAME=?");
								$result->bindParam(1,$_SESSION['ID']);
								$result->execute();
								echo '<div class="alert"><div class="add_permission" >Admin approval expected...</div> </div>';
							}
							else
							{
								echo '<div class="alert"><div class="add_permission" >Invalid permission time... </div> </div>';
							}
						}
					}
					else
						echo '<div class="alert"><div class="add_permission" >You have already permission..</div></div><br>';
				}
				else if(isset($_POST['back']))
				{
					echo location(0, "login.php");
				}
				elseif(isset($_POST['list']))
				{
					echo location(0, "permission_list.php");
				}

			}
?>
</div>
	</body>
</html>
<?php
		}
	}
	else echo location(0, "index.php");
?>
