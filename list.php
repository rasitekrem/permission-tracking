<?php
include("connect.php");

if(isset($_SESSION['ID']))
{
	if(htmlspecialchars($_SESSION['ID'],ENT_QUOTES)!="admin")
	{
		echo location(0, "login.php");
	}

	else
	{
		$department= array("Data Processing","Public Relations","Sales Responsible","Technical Support","R & D (Research-Development)");
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
<form action="list.php" method="POST">
<select name="department">
														<option value="all">< All  ></option>
														<?php
															foreach($department as $dep)
															{
																	echo '<option value="'.$dep.'">'.$dep.'</option>';
															}
														?>
													</select>
													<input type="submit" value="Filter" name="filter">
													<input type="submit" value="Back" name="back">

</form>
<div class="table">
<table >


	<thead>
		<tr>
			<th><h1>Identity Number</h1></th>
			<th><h1>Name&Surname</h1></th>
			<th><h1>Phone Number</h1></th>
			<th><h1>Department</h1></th>
			<th><h1>Permission Day</h1></th>
			<th><h1>Permission Status</h1></th>
			<th><h1>Permission Start</h1></th>
			<th><h1>Permission End</h1></th>
		</tr>
	</thead>
	<tbody>
	<?php

		$stmt=$db->prepare("select * from systemTable");

		if(isset($_POST['back']))
		{
			echo location(0, "admin.php");
		}
		else if(isset($_POST['filter']))
		{
			if($_POST['department']!="all")
			{
				$stmt=$db->prepare("select * from systemTable where DEPARTMENT=?");
				$stmt->bindParam(1,$_POST['department']);


			}


		}
		$stmt->execute();
		if($stmt->rowCount()>0)
			{

				while($fetch=$stmt->fetch(PDO::FETCH_ASSOC))
				{
					##htmlspecialchars(..) for avoiding xss##
				echo '<tr>
				<td>'. htmlspecialchars($fetch['IDENTITY_NO']).'</td>
				<td>'. htmlspecialchars($fetch['NAME'].' '.$fetch['SURNAME']).'</td>
				<td>'. htmlspecialchars($fetch['PHONE_NO']).' </td>
				<td>'. htmlspecialchars($fetch['DEPARTMENT']).'</td>
				<td>'. htmlspecialchars($fetch['PERMISSION_DAY']).'</td>
				<td>'. htmlspecialchars($fetch['PERMISSION_STATUS']).'</td>
				<td>'. htmlspecialchars($fetch['PERMISSION_START']).'</td>
				<td>'. htmlspecialchars($fetch['PERMISSION_END']).'</td></tr>';
				}
			}

}
}
else
{
	echo location(0, "index.php");
}
?>
	</tbody>
</table>
</div>
</div>
	</body>
</html>
