
<?php
	$db = mysqli_connect("localhost", "root", "", "recipes");
?>

<menu>
	<form action="?page=recipes" method="post">
		<input type="text" name="search" value="<?php echo @$_POST["search"]; ?>" />
		<input type="submit" value="search" />
	</form>

<?php
#menu : search and filter
#world_cuisine
$response = mysqli_query($db, "select * from world_cuisine");
echo "<a href='?page=".$_GET["page"]."&world=0'>World cuisine:</a>";
while($row = mysqli_fetch_array($response))
{
	$nr = $row["world_cuisine_nr"];
	$name = $row["world_cuisine_name"];

	# count rows
	$response2 = mysqli_query($db, "select count(*) from recipes where world_cuisine_fk = $nr");
	$row2 = mysqli_fetch_array($response2);

	$sum = $row2[0];

	
	$selection = "";
	if(isset($_GET["world"]) && $_GET["world"] == $nr)
	{
		$selection = "-->";
	}
	
	echo "<a href='?page=".$_GET["page"]."&world=$nr'> $selection $name ($sum)</a>";
}

#cooking_style
$response = mysqli_query($db, "select * from cooking_style");
echo "<a href='?page=".$_GET["page"]."&cooking=0'>Cooking style:</a>";
while($row = mysqli_fetch_array($response))
{
	$nr = $row["cooking_style_nr"];
	$name = $row["cooking_style_name"];

	$response2 = mysqli_query($db, "select count(*) from recipes where cooking_style_fk = $nr");
	$row2 = mysqli_fetch_array($response2);

	$sum = $row2[0];	
	$selection = "";
	if(isset($_GET["cooking"]) && $_GET["cooking"] == $nr)
	{
		$selection = "-->";
	}	
	echo "<a href='?page=".$_GET["page"]."&cooking=$nr'> $selection $name ($sum)</a>";
}

#meal_type
$response = mysqli_query($db, "select * from meal_type");
echo "<a href='?page=".$_GET["page"]."&meal=0'>Meal type:</a>";
while($row = mysqli_fetch_array($response))
{
	$nr = $row["meal_type_nr"];
	$name = $row["meal_type_name"];

	$row2 = mysqli_query($db, "select count(*) from recipes where meal_type_fk = $nr");
	$row2 = mysqli_fetch_array($row2);

	$sum = $row2[0];
	
	$selection = "";
	if(isset($_GET["meal"]) && $_GET["meal"] == $nr)
	{
		$selection = "-->";
	}	
	echo "<a href='?page=".$_GET["page"]."&meal=$nr'> $selection $name ($sum)</a>";
}
?>
</menu>

<!--  -->
<div class="teaser_box">

<?php

$befehl = "SELECT distinct
			recipe_nr,
			title,
			instructions,
			image,
			world_cuisine_name,
			cooking_style_name,
			meal_type_name
			FROM recipes
			
			JOIN
								world_cuisine ON world_cuisine.world_cuisine_nr = recipes.world_cuisine_fk
								JOIN
								cooking_style ON cooking_style.cooking_style_nr = recipes.cooking_style_fk
								JOIN
								meal_type ON meal_type.meal_type_nr = recipes.meal_type_fk";
$zusatz = array();
if(isset($_POST["search"]))
{	
	$zusatz[] = " (title LIKE '%".$_POST["search"]."%' 
				OR instructions LIKE '%".$_POST["search"]."%')";
}			
if(isset($_GET["world"]))
{
	$zusatz[] = " world_cuisine_fk = ".$_GET["world"];
}
if(isset($_GET["cooking"]))
{
	$zusatz[] =  " cooking_style_fk = ".$_GET["cooking"];
}
if(isset($_GET["meal"]))
{
	$zusatz[] =  " meal_type_fk = ".$_GET["meal"];
}

if(count($zusatz) > 0)
{
	$erweiterung = implode(" and ", $zusatz);
	$befehl .= " where " . $erweiterung;
} 

#echo $befehl;
$response = mysqli_query($db, $befehl);

while($row = mysqli_fetch_array($response))

{	
	$image = $row["image"];
	$recipe_nr = $row["recipe_nr"];
	$title = $row["title"];
		

#view all recipes
	/* $response2 = mysqli_query($db, "SELECT * from recipes
								JOIN
								world_cuisine ON world_cuisine.world_cuisine_nr = recipes.world_cuisine_fk
								JOIN
								cooking_style ON cooking_style.cooking_style_nr = recipes.cooking_style_fk
								JOIN
								meal_type ON meal_type.meal_type_nr = recipes.meal_type_fk");
	

print_r($response2);

	while ($row = mysqli_fetch_array($response2))
	{  */	
		echo "<div class='teaser'>";
				
		$recipe_nr = $row["recipe_nr"];	
		echo "<a href='?page=recipes&recipe_nr=$recipe_nr'>
			<p>#".$recipe_nr."</p>";
			$title = $row["title"];
			echo "<p>".$title."</p>";
		echo "</a>";					
			
		$world = $row["world_cuisine_name"];
		echo "<p>Origin: ".$world."</p>";
		$cooking = $row["cooking_style_name"];
		echo "<p>Cooking-style: ".$cooking."</p>";
		$meal = $row["meal_type_name"];
		echo "<p>Meal-type: ".$meal."</p>";
		$image = $row["image"];
		echo "<img src='img/$image' />";	
		
		echo "<a href='?page=recipes&watch=$recipe_nr'>Add to favorites</a>";

		echo "</div>";
		
	
}	
echo "</div>";

mysqli_close($db);
?>