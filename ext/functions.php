<?php

function url($page, $name)
{
	$string = "<a href='?page=$page'>$name</a>";
	return $string;
}

function generate_links($array)
{
	$string = "";
	foreach($array as $page => $text)
	{
		$string .= url($page, $text);
	}	
	return $string;
}

?>