<?php

	include("connect.php");
	if(isset($_SESSION['ID']))
	{
		if(htmlspecialchars($_SESSION['ID'],ENT_QUOTES)!="admin")
		{
			echo location(0, "permission_list.php");
		}
		else
		{
			$stmt=$db->prepare("select * from permissionControl where PERMISSION_APPROVAL='Approval Waiting'");
			$stmt->execute();

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script type="text/javascript">
					// Verify Or Denied //
					function Check_a(Object)
					{
					var change=Object.id.charAt(1);
					change="b"+change;
					change=change.toString();
					var obj=document.getElementById(change);

					if(Object.checked)
					{

						obj.checked=!Object.checked;


					}

				}
				function Check_b(Object)
				{
					var change=Object.id.charAt(1);
					change="a"+change;
					change=change.toString();
					var obj=document.getElementById(change);
					if(Object.checked)
					{
						obj.checked=!Object.checked;

					}

				}
		</script>
	</head>
	<body>
		<div class="body"></div>
		<div class="grad"></div>
		<div class="welcome"><div>Welcome <span><?php echo htmlspecialchars($username,ENT_QUOTES);?></span> </div></div>
		<div class="container" >
					<form name="frm" action="permission_verify.php" method="POST">
						<input type="submit" name="save" value="Confirm">
							<input type="reset"  value="Clear">
							<input type="submit" name="back" value="Back">
						<table>
							<tr>
								<th><h1>Identity Number</h1></th>
								<th><h1>Permission Start</h1></th>
								<th><h1>Permission End</h1></th>
								<th><h1>Permission Status</h1></th>
								<th><h1>Permission Day</h1></th>
								<th><h1>New Permission Day</h1></th>
								<th><h1>Verify</h1></th>
								<th><h1>Denied</h1></th>
							</tr>
							<?php
								if($stmt)
								{
										$i=0;
										while($result=$stmt->fetch(PDO::FETCH_ASSOC))
										{
											echo '<tr>
													<td>'.$result['USERNAME'].'</td>
													<td>'.$result['PERMISSION_START'].'</td>
													<td>'.$result['PERMISSION_END'].'</td>
													<td>'.$result['PERMISSION_APPROVAL'].'</td>
													<td>'.$result['PERMISSION_DAY'].'</td>
													<td>'.$result['NEW_PERMISSION_DAY'].'</td>
													<td><input type="checkbox" id="a'.$i.'" name="verify[]" onClick="Check_a(this)" value="'.$result['ID'].'"></td>
													<td><input type="checkbox" id="b'.$i.'" name="denied[]" onClick="Check_b(this)" value="'.$result['ID'].'"></td>
													</tr>';
													$i++;
										}
								}
							?>

						</table></div>

					</form>

	</body>
</html>

<?php

			if($_POST)
			{
				if(isset($_POST['save']))
				{
					foreach($_POST['verify'] as $confirm)
					{
						$stmt = $db->prepare("select * from permissionControl where ID=?");
						$stmt->bindParam(1,$confirm);
						$stmt->execute();
						$row=$stmt->fetch(PDO::FETCH_ASSOC);
						$stmt = $db->prepare("update systemTable set PERMISSION_DAY=:new_day,PERMISSION_STATUS='Permitted',
																								PERMISSION_START=:permission_start,PERMISSION_END=:permission_end where USERNAME=:username");
						$stmt->bindParam(':new_day',$row['NEW_PERMISSION_DAY']);
						$stmt->bindParam(':permission_start',$row['PERMISSION_START']);
						$stmt->bindParam(':permission_end',$row['PERMISSION_END']);
						$stmt->bindParam(':username',$row['USERNAME']);
						$stmt->execute();
						$stmt = $db->prepare("update permissionControl set PERMISSION_APPROVAL='Permitted' where ID=?");
						$stmt->bindParam(1,$confirm);
						$stmt->execute();
						echo '<div class="alert"><div class="add" >'.htmlspecialchars($confirm,ENT_QUOTES).'</div> </div>';

					}
					foreach($_POST['denied'] as $confirm)
					{
						$result=$db->prepare("select NEW_PERMISSION_DAY,USERNAME from permissionControl where ID=?");
						$result->bindParam(1,$confirm);
						$result->execute();
						$result = $result->fetch(PDO::FETCH_ASSOC);
						$stmt = $db->prepare("update systemTable set PERMISSION_STATUS='Working' where USERNAME=?");
						$stmt->bindParam(1,$result['USERNAME']);
						$stmt->execute();
						$stmt = $db->prepare("update permissionControl set PERMISSION_APPROVAL='Denied' where ID=? ");
						$stmt->bindParam(1,$confirm);
						$stmt->execute();
						echo '<div class="alert"><div class="add" >'.htmlspecialchars($confirm,ENT_QUOTES).'</div> </div>';
					}
					echo location(0, "permission_verify.php");
				}
				elseif($_POST['back'])
				{
					echo location(0,"admin.php");
				}

			}
		}
	}
	else
	{
		echo location(0, "index.php");
	}
?>
