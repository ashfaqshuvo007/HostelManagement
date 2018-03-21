<?php

include 'inc/connection.php';

if(isset($_GET['pid'])){


$query = $connection->prepare("SELECT * FROM `payment` WHERE `payment_id` = :pid");
$query->bindValue(':pid',$_GET['pid'],PDO::PARAM_INT);
$query->execute();
$pdata = $query->fetch();


$stmt = $connection->prepare("INSERT INTO `paid_bills`(`payment_id`,`border_id`) VALUES(:payment_id,:border_id)");
$stmt->bindValue('payment_id',$pdata['payment_id']);
$stmt->bindValue('border_id',$pdata['border_id']);
$stmt->execute();


$d_qry = $connection->prepare("DELETE FROM `payment` WHERE `payment_id` = :pid");
$d_qry->bindValue(':pid',$_GET['pid'],PDO::PARAM_INT);
$d_qry->execute();

header('Location: payments.php');


}









?>