<?php

function getDB(){
	$hostname="localhost";
	$dbName="library";
	$username="root";
	$password="";
	$dbh = new PDO("mysql:host=$hostname;dbname=$dbName",$username,$password);
	return $dbh;
}