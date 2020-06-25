<div>
<a href="?page=recipes">Back to recipes</a>

<?php
$db = mysqli_connect("localhost","root","","recipes");
#$response = mysqli_query($db, "select * from recipes where recipe_nr = ".$_GET["recipe_nr"]);

$response = mysqli_query($db, "SELECT * 
							from recipes 	
							JOIN
							recipe_ingredients ON recipe_ingredients.recipe_fk = recipes.recipe_nr
							JOIN
							ingredient ON ingredient.ingredient_nr = recipe_ingredients.ingredient_fk
							JOIN
							measurement ON measurement.measurement_nr = recipe_ingredients.measurement_fk 
							where recipe_nr = ".$_GET["recipe_nr"]														
							);
#print_r($db);
$row = mysqli_fetch_array($response);
?>

<div class="">	
		<img src="img/<?php echo $row["image"]; ?>" />
        <h1><?php echo $row["title"] ?></h1>
		<p><?php echo $row["instructions"] ?></p>        
        <p>Score: <?php echo $row["score"]?></p>
	    <p>Date: <?php echo $row["date"]?></p>
        
</div>

<?php
	#echo "<table border='1'>";
	echo "<table>";
	echo "<tr>";
		echo "<td>Ingredient</td>";
		echo "<td>Amount</td>";
		echo "<td>Measurement unit</td>";
	echo "</tr>";

	while($row = mysqli_fetch_array($response))
	{
		echo "<tr>";
		echo "<td>".$row["ingredient_name"]."</td>";
		echo "<td>".$row["amount"]."</td>";
		echo "<td>".$row["measurement_name"]."</td>";
	}
	echo "</table>";
?>

<button>
	<a href='?page=recipes&watch=<?php echo $row["recipe_nr"]; ?>'>Add to favorites</a>
</button>

<?php
mysqli_close($db);
?>