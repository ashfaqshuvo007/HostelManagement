<?php
include 'inc/connection.php';

if(isset($_GET['border_id'])){

	//All rooms info
	$qry = $connection->prepare("SELECT `room_id` FROM `borders` WHERE `border_id` = :border_id");
	$qry->bindValue(':border_id', $_GET['border_id'],PDO::PARAM_INT);
	$qry->execute();
	$b_data = $qry->fetch();

	$r_qry = $connection->prepare("SELECT `existing_border` FROM `rooms` WHERE `room_id` = :room_id");
	$r_qry->bindValue(':room_id', $b_data['room_id']);
	$r_qry->execute();
	$r_data = $r_qry->fetch();

	//decrements room border number
	$existing_border = $r_data['existing_border']-1;

	$r_qry = $connection->prepare("UPDATE `rooms` SET `existing_border` = :existing_border WHERE `room_id` = :room_id");
	$r_qry->bindValue(':existing_border', $existing_border);
	$r_qry->bindValue(':room_id', $b_data['room_id']);
	$r_qry->execute();

	if($r_qry->rowCount() === 1){
		$qry = $connection->prepare("DELETE FROM `borders` WHERE `border_id` = :border_id");
		$qry->bindValue(':border_id', $_GET['border_id'],PDO::PARAM_INT);
		$qry->execute();

		if ($qry->rowCount() === 1) {
		$msgs[] = "Border Deleted Successfully";
		$stmt = $connection->prepare("ALTER TABLE `borders` AUTO_INCREMENT = 1");
		$stmt->execute();
	}
		header('Location: borders.php');
		
	}

}





?>