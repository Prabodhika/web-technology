<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_GET) && isset($_GET['id'])) {
    $loanId = $_GET['id'];
    require 'DB.php';
    $pdo = getDB();
    $statement = $pdo->prepare('UPDATE loan SET received_date=:date,returned=:returned WHERE id=:id');
    $success = $statement->execute([':id' => $loanId, ':date' => date('Y-m-d'), ':returned' => TRUE]);
}

header('Location: ' . $_SERVER['HTTP_REFERER'] . '&state=2');

