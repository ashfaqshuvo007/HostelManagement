<?php 
include 'inc/connection.php';

if (isset($_GET['room_id'])) {
	$delete = $connection->prepare("DELETE FROM `rooms` WHERE `room_id` = :room_id");
	$delete->bindValue(':room_id', $_GET['room_id'], PDO::PARAM_INT);
	$delete->execute();

	if ($delete->rowCount() === 1) {
		header('location: rooms.php');
	}
}

?>