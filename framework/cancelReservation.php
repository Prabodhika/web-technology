<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_GET) && isset($_GET['id'])) {
    $reservationId = $_GET['id'];
    require 'DB.php';
    $pdo = getDB();
    $statement = $pdo->prepare('DELETE FROM reservation WHERE id=:id');
    $success = $statement->execute([':id' => $reservationId]);
}

header('Location: ' . $_SERVER['HTTP_REFERER'].'&state=2');

