
<div class="teaser_box">
<?php
$db = mysqli_connect("localhost","root","","recipes");
?>

<?php
#print_r($watchlist);
$watchlist_string = implode(",", $watchlist); # konvertieren in einen String
#print_r($watchlist_string);

$query = "SELECT * FROM recipes WHERE recipe_nr IN ($watchlist_string)";
#$query = "SELECT * FROM recipes WHERE recipe_nr"; für alle
#echo $query;

$response = mysqli_query($db, $query);

while($row = mysqli_fetch_array($response)) 
{
    $img = $row["image"];
	$recipe_nr = $row["recipe_nr"];
    $title = $row["title"];

    $output = "
	<div class='teaser'>
		<img src='img/$img' />
		<div>(RecipeNr $recipe_nr) $title</div>
		<a href='?page=recipes&recipe_nr=$recipe_nr'>View details</a>       
    </div>";
	echo $output;
}
?>	

</div>	
<?php
mysqli_close($db);
?>