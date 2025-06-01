<?php
include 'conn.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM korpa WHERE korpa_id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();


header("Location: korpa.php");
exit();
?>
