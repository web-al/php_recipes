<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

if(isset($_SESSION["loggedin"]))
{
	echo "<form><pre>";
	print_r($_POST);
	echo "</pre></form>";
	
	$db = mysqli_connect("localhost","root","","recipes");

	if(isset($_POST["add_recipe"])) 
	{
		$new_name = uniqid().".jpg";
		# Dateien aus dem tmp-Verzeichnis kopieren in das Uploads verzeichnis
		copy("tmp/".$_POST["img"],"img/".$new_name);
		# temporäres bild löschen
		unlink("tmp/".$_POST["img"]);
		
		$title 				= $_POST["title"];
		$instructions 		= $_POST["instructions"];
		$date 				= $_POST["date"];
		$world_cuisine		= $_POST["world_cuisine"];
		$cooking_style		= $_POST["cooking_style"];
		$meal_type			= $_POST["meal_type"];
		$ingredient_name 	= $_POST["ingredient_name"];
		$amount 			= $_POST["amount"];
		$measurement	 	= $_POST["measurement"];
		$img				= $_POST["img"];	
	
		#mysqli_select_db('recipes') or die('fehler'); # programm beenden

		
		mysqli_query($db, "insert into recipes
			(
				title,	
				instructions, 
				world_cuisine_fk, 
				cooking_style_fk,
				meal_type_fk,										
				image
			)
			values
			( 
				'$title',	
				'$instructions', 
				'$world_cuisine', 
				'$cooking_style', 
				'$meal_type',
				'$img'																			
			)
		");
	
		echo "<h1>".$db->error."</h1>"; # Fehlermeldungen
		echo "Der Datensatz wurde gespeichert!";
		echo "<h1>".$db->insert_id."</h1>"; # Primärschlüssel	
		
		$recipe_fk = $db->insert_id;

		echo "tehsdgh: ".$_POST["ingredient_name"];
		foreach($_POST["ingredient_name"] as $nr => $unused)
		{	
			if(strlen($_POST["ingredient_name"][$nr]) !== 0)
			{
			echo "<pre>";
				echo $_POST["ingredient_name"][$nr];
				echo $_POST["amount"][$nr];
				echo $_POST["measurement"][$nr];
			echo "</pre>";
			
				mysqli_query($db, "insert into ingredient
					(
						ingredient_name
					)
					values
					( 
						'".$_POST["ingredient_name"][$nr]."'
					)							
				");
			
				/*echo "insert into ingredient
						(
							ingredient_name
						)
						values
						( 
							'".$_POST["ingredient_name"][$nr]."'
						)							
					";*/
				$ingredient_fk = $db->insert_id;
				$amount = $_POST["amount"];

			
				$ingredient_name++;
				$befehl = "insert into recipe_ingredients 
								(recipe_fk,ingredient_fk,measurement_fk,amount)
							values 
								($recipe_fk,$ingredient_fk,".$_POST["measurement"][$nr].",'".$_POST["amount"][$nr]."')
						  ";
				#echo $befehl."<br />";
				mysqli_query($db, $befehl);
			}
		} 
		
		/* 
		mysqli_query($db, "insert into recipe_ingredients
			(
				recipe_fk,	
				ingredient_fk, 
				amount,
				measurement_fk 
			)
			values
			( 
				$recipe_fk,
				$ingredient_fk,
				$amount,
				'$measurement'
			);							
		");	  */
	}
		
		
		
			
	
	# $measurement_fk = $_POST[measurement][measurement_nr] ?
					
	
	
	
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
		$new_name = uniqid().".jpg";
		move_uploaded_file($_FILES["img"]["tmp_name"], "tmp/".$new_name);
		echo "<form action='?page=add_recipe' method='post'>";
		echo "<h1>STEP 2: Add recipe details</h1>";	
		echo "<img src='tmp/".$new_name."' height='200'>";
		echo "<input type='hidden' name='img' value='".$new_name."' />";
	
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
					echo "<input type='text' name='ingredient_name[]' />";
					echo "<input type='text' name='amount[]' />";
					echo "<select name='measurement[]'>";
					
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