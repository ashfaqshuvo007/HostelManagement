<?php 
include 'inc/connection.php';

if (isset($_GET['doc_id'])) {
	$delete = $connection->prepare("DELETE FROM `documents` WHERE `doc_id` = :doc_id");
	$delete->bindValue(':doc_id', $_GET['doc_id'], PDO::PARAM_INT);
	$delete->execute();

	if ($delete->rowCount() === 1) {
		header('location: Documents.php');
	}
}

?>