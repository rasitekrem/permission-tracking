<?php
	include("connect.php");
	# Session Control #
	if(!isset($_SESSION['ID']) || htmlspecialchars($_SESSION['ID'],ENT_QUOTES)!="admin")
	{
		echo location(0,"index.php");
	}
	else
	{
		# Department List Array #
		$department= array("Data Processing","Public Relations","Sales Responsible","Technical Support","R & D (Research-Development)");

?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>

	<body>
			<div class="body"></div> <!-- Background and Body Settings -->
		<div class="welcome"><div>Welcome <span><?php echo htmlspecialchars($username,ENT_QUOTES);?></span> </div></div>
		<div class="grad"></div><!--Background settings-->
	<div class="admin">

		<form action="add.php" method="POST">
		</div>
			<div class="addform">
								<!-- Add Personnel -->
								<input type="text" placeholder="Name" name="name"><br>
								<input type="text" placeholder="Surname" name="surname"><br>
								<input type="text" placeholder="Identification Number" name="id_no"><br>
								<input type="text" placeholder="Phone Number" name="mobile"><br>
								<div class="selects">
													<select name="department">
														<option value="nonselected">< Working Departments ></option>
														<?php
															foreach($department as $dep)
															{
																	echo '<option value="'.$dep.'">'.$dep.'</option>';
															}
														?>
													</select><br>

								<input type="submit" value="Save" name="save">
								<input type="reset" value="Clear">
								<input type="submit" value="Back" name="back">
								</div>
	</form>
</div>
	</body>
</html>

<?php
	}
	if($_POST)
	{

		if(isset($_POST['save']))
		{	## Space Control ##
			if(!isset($_POST['name']) || !isset($_POST['surname']) || !isset($_POST['mobile']) || !isset($_POST['id_no']) || $_POST['department']=="nonselected")
			{
				echo '<div class="alert"><div class="add" > Mustn\'t No Space ! </div> </div>';
			}
			else
			{


				## Default username=password. username=strtolower -- namesurname ##
				$personel_id=mb_strtolower($_POST['name'].$_POST['surname'], "UTF-8"); ## username create ##

				$personel_id = str_replace(' ', '', $personel_id);## destroy space ##

				## Avoiding SQL injection ##
				$stmt = $db->prepare("INSERT INTO systemTable (USERNAME,NAME,SURNAME,DEPARTMENT,PHONE_NO,IDENTITY_NO)
				 											VALUES(:personel_id,:name,:surname,:department,:mobile,:id_no)");
				$stmt->bindParam(':personel_id',$personel_id);
				$stmt->bindParam(':name',$_POST['name']);
				$stmt->bindParam(':surname',$_POST['surname']);
				$stmt->bindParam(':department',$_POST['department']);
				$stmt->bindParam(':mobile',$_POST['mobile']);
				$stmt->bindParam(':id_no',$_POST['id_no']);
				$stmt->execute();

				$stmt = $db->prepare("INSERT INTO users (USERNAME,PASSWORD) values(?,?)");
				$stmt->bindParam(1,$personel_id);
				$stmt->bindParam(2,$personel_id);
				$stmt->execute();
				echo '<div class="alert"><div class="add" >Successfully Added. '.htmlspecialchars($personel_id,ENT_QUOTES).'</div> </div>';

			}
		}
		else if(isset($_POST['back']))
		{

			echo location(0,"admin.php");
		}

	}
?>
