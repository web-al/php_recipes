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
		if(isset($_GET["recipe_nr"]))
		{
			# selected recipe
			include("recipe_view_details.php");
		}
		else
		{
			# all recipes
			include("recipes_view.php");
		}
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

	case "register":
	
		if(isset($_POST["new_user"]))
		{
			$db = mysqli_connect("localhost","root","","recipes");
			$login = $_POST["new_user"];
			$email = $_POST["new_email"];
			$password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);

			$query = "insert into user (login, password, email)
						values ('$login','$password','$email')";
			echo $query;
			mysqli_query($db,$query);
			print_r($db);
			mysqli_close($db);
		}

		echo "<form method='post'>
		User:<input type='text' name='new_user'>
		E-Mail:<input type='text' name='new_email'>
		Password:<input type='password' name='new_password' />
		<button type='submit'>Create a profile</button>
		</form>";			


break;	


	default:
		echo "<h1>Error</h1>";
}

?>