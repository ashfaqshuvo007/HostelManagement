<?php 

include 'inc/connection.php';

if($_GET['room_id']){

	$id = (int)$_GET['room_id'];


	$stmt = $connection->prepare("SELECT * FROM `rooms` WHERE `room_id` = :rid");
	$stmt->bindValue('rid',$id);
	$stmt->execute();
	$room = $stmt->fetch();


	if($room['status'] == 1){
		$update = $connection->prepare("UPDATE `rooms` SET `status` = '0' WHERE `room_id` = :rid ");
		$update->bindValue('rid',$id);
		$update->execute();
	}else if($room['status'] == 0){
		$update = $connection->prepare("UPDATE `rooms` SET `status` = '1' WHERE `room_id` = :rid ");
		$update->bindValue('rid',$id);
		$update->execute();
	}
	header('Location: rooms.php');
}
?>