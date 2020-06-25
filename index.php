<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
#$user = "user";
#$password = "password";

session_start();
require_once("ext/functions.php");

if(isset($_POST["user"]))
{	
	$db = mysqli_connect("localhost","root","","recipes");
	mysqli_query($db,"set names utf8");
	
	# SQL-Injection verhindern
	$_POST["user"] = mysqli_real_escape_string($db,$_POST["user"]);
	$_POST["password"] = mysqli_real_escape_string($db,$_POST["password"]);
	
	$query = "select * from user where login='".$_POST["user"]."'";
	
	echo "<h1>$query</h1>";
	$response = mysqli_query($db, $query);
	echo "<pre>";
	print_r($db);
	print_r($response);
	echo "</pre>";
	#print_r($antwort);
	if($response->num_rows == 1)
	{
		$row = mysqli_fetch_array($response);
		#					lesbare				hashwert
		print_r($_POST["password"]);
		print_r($row["password"]);
		
		if (1==1)
		#if(password_verify($_POST["password"], $row["password"]))
		{
			$_SESSION["loggedin"] = true;
			echo "hallo";
		}
		else
		{
			echo "else";
			$loginerror = "Incorrect password";
		}
		
	}
	else
	{
		$loginerror = "Login failed";
	}
	/* if($_POST["user"] == $user && $_POST["password"] == $password)
	{
		$_SESSION["loggedin"] = true;
	}
	else
	{
		$login_error = "login failed";
	} */
}

if(isset($_COOKIE["watchlist"]))
{
	$watchlist = explode(";",$_COOKIE["watchlist"]);
	$watchlist_count =  count($watchlist);
}
else
{
	$watchlist = array();
	$watchlist_count = 0;
}

# watch
if(isset($_GET["watch"]))
{
	if(isset($_COOKIE["watchlist"]))
	{
		$string = $_COOKIE["watchlist"].";".$_GET["watch"];
		if(!in_array($_GET["watch"], $watchlist)) # if ... not in array yet
		{
			setcookie("watchlist",$string);
			$watchlist_count++;
		}		
	}
	else
	{
		$string = $_GET["watch"];
		setcookie("watchlist",$string);
		$watchlist_count++;
	}
}

?>

<html>
<head>
	<title>Recipes</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="css/optik.css" />	
</head>
<body>

<header>

<?php
$linklist = array(
	"recipes" => "Recipes",
	"add_recipe" => "Add recipe",
	"watchlist" => "Favorites ($watchlist_count)"					
);
echo generate_links($linklist);					
?>
</header>

<main>

<?php
#print_r($_POST);

if(isset($_POST["cookies"]) || isset($_COOKIE["website_cookie"]))
{
	setcookie("website_cookie","aktiviert", time() + 60 * 60 * 24 * 365 * 4);
}
else
{
	echo "<div style='position:absolute; bottom:50px; left: 50px; z-index: 1000; background-color:grey;'>
	We use cookies to do things like remember what you've added to your watchlist. If you're happy wth the use of cookies, click OK.
	<form method=\"post\"><input type=\"submit\" name=\"cookies\" value=\"OK\" /></form>
	</div>";
}
?>

<div class='layout'>

<?php
if(isset($login_error))
{
	echo $login_error;
}
include("ext/app.php");
?>	

</div>

</main>

<footer>
<?php
if(isset($_SESSION["loggedin"]))
{
	echo generate_links(array("logout" => "Logout"));
}
else
{
	echo generate_links(array("login" => "Login"));
	echo generate_links(array("register" => "Create a profile"));
}
?>
</footer>

</body>
</html>