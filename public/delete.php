<?php
include "../config/database.php";

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM contacts WHERE id=?");
$stmt->execute([$id]);

header("Location: index.php");
exit();
?>
