<?php
require('DB.php');

$pdo=getDB();
$statement=$pdo->prepare("INSERT INTO student (name,class,phone, registration_number, registered_at) VALUES (:name,:class,:phone,:reg,:time)");
$status=$statement->execute(['name'=>$_POST['name'],'class'=>$_POST['class'],'phone'=>$_POST['phone'],'reg'=>$_POST['registrationNumber'],'time'=>date("Y-m-d H:i:s")]);
header('Location: ' . $_SERVER['HTTP_REFERER']);
