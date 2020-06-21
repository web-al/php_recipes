<?php

# a) no page selected
if(isset($_GET["page"]) == false)
{
	$_GET["page"] = "Recipes"; # sets startpage
}

# b) page selected	
switch($_GET["page"])
{
	case "recipes":	
		include("recipes.php");
	break;
	
	case "add_recipe":	
		include("add_recipe.php");
	break;

	case "watchlist":	
		include("watchlist.php");	
	break;	

	case "logout":
		echo "logged out";
		unset($_SESSION["loggedin"]); # execute logout
	break;

	case "login":
		if(isset($_SESSION["loggedin"]))
		{
			echo "logged in";
			echo "<a href='?page=logout'>Logout</a>";				
		}
		else
		{
			echo
				"<form method='post'>
					<input type='text' name='user'>
					<input type='password' name='password' />
					<button type='submit'>Login</button>
				</form>";			
		}

	break;

	default:
		echo "<h1>Error</h1>";
}

?>