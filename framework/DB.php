
<?php

function getDB(){
	$hostname="localhost";
	$dbName="library";
	$username="root";
	$password="root";
	$dbh = new PDO("mysql:host=$hostname;dbname=$dbName",$username,$password);
	return $dbh;
}