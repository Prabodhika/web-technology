<?php 
if(!empty($_GET) && !empty($_GET['loan_id'])){
	require("DB.php");
	
	$pdo=getDB();
	$stmt=$pdo->prepare("SELECT count(*) FROM reminder WHERE loan_id=:id");
	$stmt->execute(['id'=>$_GET['loan_id']]);
	$count=$stmt->fetch()[0];
	
	if($count<3){
		$stmt=$pdo->prepare("INSERT INTO reminder (loan_id,reminder_no) values(:id,:reminder_no)");
		$stmt->execute(['id'=>$_GET['loan_id'],'reminder_no'=>$count+1]);
	}
}
header('Location: ' . $_SERVER['HTTP_REFERER'].'&state=1');