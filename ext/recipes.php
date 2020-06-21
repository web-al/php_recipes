<h1>Recipes</h1>
<?php
$db = mysqli_connect("localhost", "root", "", "recipes");

#$response = mysqli_query($db, "SELECT * from recipes");

/* $response = mysqli_query($db, "SELECT * 
								FROM world_cuisine 
								LEFT JOIN recipes ON world_cuisine.world_cuisine_nr = recipes.world_cuisine_fk");
*/

$response = mysqli_query($db, "	SELECT
									recipe_nr,
									title,
									instructions,
									recipes.world_cuisine_fk,
									recipes.cooking_style_fk,
									recipes.meal_type_fk,
									image,
									score,
									date
								FROM
									recipes
								JOIN
									world_cuisine ON world_cuisine.world_cuisine_nr = recipes.world_cuisine_fk
								");

print_r($response);

/* while ($row = mysqli_fetch_array($response))
{
	$recipe_nr = $row["recipe_nr"];
	echo "<p>#".$recipe_nr."</p>";
	$title = $row["title"];
	echo "<p>".$title."</p>";
	$instructions = $row["instructions"];
	echo "<p>".$instructions."</p>";
	$world = $row["world_cuisine_fk"];
	echo "<p>".$world."</p>";
	$cooking = $row["cooking_style_fk"];
	echo "<p>".$cooking."</p>";
	$meal = $row["meal_type_fk"];
	echo "<p>".$meal."</p>";
	$image = $row["image"];
	echo "<p>".$image."</p>";	
	$score = $row["score"];
	echo "<p>".$score."</p>";
	$date = $row["date"];
	echo "<p>".$date."</p>";
} */
 
while ($row = mysqli_fetch_array($response))
{
	$world_cuisine_name = $row["world_cuisine_n"];
	echo "<p>".$world_cuisine_name."</p>";
}

mysqli_close($db);
?>