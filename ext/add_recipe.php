<?php
if(isset($_SESSION["loggedin"]))
{
	echo "<form><pre>";
	print_r($_POST);
	echo "</pre></form>";
	
	$db = mysqli_connect("localhost","root","","recipes");
	if(isset($_POST["add_recipe"]))
	{
			$neuer_name = uniqid().".jpg";
			# Dateien aus dem tmp-Verzeichnis kopieren in das Uploads verzeichnis
			copy("tmp/".$_POST["img"],"uploads/".$new_name);
			# temporäres bild löschen
			unlink("tmp/".$_POST["img"]);
			
	}	
	#die(); # programm beenden
		
	$title 				= $_POST["title"];
	$instructions 		= $_POST["instructions"];
	$date 				= $_POST["date"];
	$world_cuisine		= $_POST["world_cuisine"];
	$cooking_style		= $_POST["cooking_style"];
	$meal_type			= $_POST["meal_type"];
	$ingredient_name 	= $_POST["ingredient_name"];
	$amount 			= $_POST["amount"];
	$measurement_name 	= $_POST["measurement_name"];
	$img				= $_POST["img"];
			
	mysqli_query($db, "insert into recipes 
									(
										title,	
										instructions, 
										world_cuisine_fk, 
										cooking_style_fk,
										meal_type_fk,										
										img
									)
									values
									(
										'$title',	
										'$instructions', 
										$world_cuisine, 
										$cooking_style, 
										$meal_type,
										$img
									);							
						
						
					");			
					
	
	if(!isset($_POST["upload"]))
	{
	?>
		
		<form action="?page=add_recipe" method="post" enctype="multipart/form-data">
			<h1>STEP 1: Picture Upload</h1>
			<input type="file" name="img" />
			<input type="submit" name="upload" value="Upload recipe image" />
		</form>
	<?php
	}
	else
	{
	?>
				
		
	<?php				
	$new_name = uniqid().".jpg";
	move_uploaded_file($_FILES["img"]["tmp_name"], "tmp/".$new_name);
	echo "<form action='?page=add_recipe' method='post'>";
	echo "<h1>STEP 2: Add recipe details</h1>";	
	echo "<img src='tmp/".$new_name."' height='200'>";
		
	?>
		
		<br />
		Title<br />
		<input type="text" name="title" />
		<br />
		Instructions<br />
		<textarea name="instructions"></textarea>
		<br />
		Date<br />
		<input type="text" name="date" value="<?php $date_time = date("d.m.Y - H:i"); echo $date_time; ?>" />
		<br />
		Origin<br />
		<select name="world_cuisine">
			<?php
				$query = mysqli_query($db, "select * from world_cuisine order by world_cuisine_name");
				while($row = mysqli_fetch_array($query))
				{
					echo "<option value='".$row["world_cuisine_nr"]."'>".$row["world_cuisine_name"]."</option>";
				}
			?>
		</select>
		<br />
		Cooking style<br />
		<select name="cooking_style">
			<?php
				$query = mysqli_query($db, "select * from cooking_style order by cooking_style_name");
				while($row = mysqli_fetch_array($query))
				{
					echo "<option value='".$row["cooking_style_nr"]."'>".$row["cooking_style_name"]."</option>";
				}
			?>
		</select>
		<br />		
		Meal type<br />
		<select name="meal_type">
			<?php
				$query = mysqli_query($db, "select * from meal_type order by meal_type_name");
				while($row = mysqli_fetch_array($query))
				{
					echo "<option value='".$row["meal_type_nr"]."'>".$row["meal_type_name"]."</option>";
				}
			?>
		</select>
		<br />			
		Ingredients<br />
		<?php
			for($i = 0; $i <= 10; $i++)
			{
				echo "<input type='text' name='ingredient_name' value='0' />";
				echo "<input type='text' name='amount' value='0' />";
				echo "<select name='measurement'>";
				
					$query = mysqli_query($db, "select * from measurement order by measurement_name");
					while($row = mysqli_fetch_array($query))
					{
						echo "<option value='".$row["measurement_nr"]."'>".$row["measurement_name"]."</option>";
					}
				
				echo "</select>";
				echo "<br />";
			}
		?>
		<br />				
		<br />
		<input type="submit" name="add_recipe" value="Add recipe" />
		
</form>
	
	<?php
	}
	mysqli_close($db);
}
else
{
	echo "Please log in!";
}
?>