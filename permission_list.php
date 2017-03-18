<?php

	include("connect.php");
	if(isset($_SESSION['ID']))
	{
		if(htmlspecialchars($_SESSION['ID'],ENT_QUOTES)=="admin")
		{
			echo location(0, "permission_verify.php");
		}
		else
		{
			$stmt=$db->prepare("select * from permissionControl where USERNAME=?");
			$stmt->bindParam(1,$_SESSION['ID']);
			$stmt->execute();
			$permissionDay=$db->prepare("select PERMISSION_DAY from systemTable where USERNAME=?");
			$permissionDay->bindParam(1,$_SESSION['ID']);
			$permissionDay->execute();
			$permissionDay=$permissionDay->fetch(PDO::FETCH_ASSOC);

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
					<form action="permission_list.php" method="POST">
						<input type="submit" name="save" value="Save">
						<input type="submit" name="cancel" value="Cancel">
						<input type="submit" name="back" value="Back">
						<div class="txt"><input type="text" <?php echo 'value="Remaining Permission Day : '.$permissionDay['PERMISSION_DAY'].'"';?> disabled></div>

						<table cellspacing="0" cellpadding="0">
							<tr>
								<th><h1>Identity Number</h1></th>
								<th><h1>Permission Start</h1></th>
								<th><h1>Permission End</h1></th>
								<th><h1>Permission Status</h1></th>
								<th><h1>Permission Day</h1></th>
								<th><h1>New Permission Day</h1></th>
								<th><h1>Remove</h1></th>
							</tr>
							<?php
								if($stmt)
								{
										while($row=$stmt->fetch(PDO::FETCH_ASSOC))
										{
											echo '<tr>
													<td>'.$row['USERNAME'].'</td>
													<td>'.$row['PERMISSION_START'].'</td>
													<td>'.$row['PERMISSION_END'].'</td>
													<td>'.$row['PERMISSION_APPROVAL'].'</td>
													<td>'.$row['PERMISSION_DAY'].'</td>
													<td>'.$row['NEW_PERMISSION_DAY'].'</td>';
													if($row['PERMISSION_APPROVAL']=="Approval Waiting" )
														{
														echo'<td></td>';
														$approval=true; ## "approval" true when active cancel process ##
														}
													else if($row['PERMISSION_APPROVAL']!="Permitted")
													{
														## Old data remove ##
														echo '<td><input type="checkbox" name="delete[]" value="'.$row['ID'].'"></td>';
													}
													else
													{
														echo'<td></td>';

													}
													echo '</tr>';


										}
								}
							?>
						</table>



					</form>


<?php
			if($_POST)
			{
				if(isset($_POST['save']))
				{
					if(isset($_POST['delete']))
					{
						$delete=$_POST['delete'];
						foreach($delete as $del)
						{
							$stmt = $db->prepare("delete from permissionControl where ID='$del'");
							$stmt->execute();
						}
							echo '<div class="alert"><div class="perList_alert" >Selected data is removing. Please waiting..</div> </div>';
							echo location(2, "permission_list.php");
					}
					else{
						echo '<div class="alert"><div class="perList_alert" >No selected item/div> </div>';
					}
				}
				elseif(isset($_POST['cancel']))
				{
					if($approval)
					{
						echo '<div class="alert"><div class="perList_alert" >Permission is canceling. Please waiting</div> </div>';
						$stmt = $db->prepare("delete from permissionControl where USERNAME=? and PERMISSION_APPROVAL='Approval Waiting'");
						$stmt->bindParam(1,$_SESSION['ID']);
						$stmt->execute();
						$stmt = $db->prepare("update systemTable set PERMISSION_STATUS='Working' where USERNAME=?");
						$stmt->bindParam(1,$_SESSION['ID']);
						$stmt->execute();
						echo location(2, "permission_list.php");
					}
					else
					{
						echo '<div class="alert"><div class="perList_alert" >No pending approval...</div> </div>';
					}
				}
				else if(isset($_POST['back']))
				{
					echo location(0, "permission.php");
				}

			}
		}
	}
else
{
 echo location(0, "index.php");
}
?>
</div>
	</body>
</html>
