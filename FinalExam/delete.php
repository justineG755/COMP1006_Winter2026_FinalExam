<!-- DELETE -->
<?php
require "includes/connect.php";
require "includes/auth.php";


// make sure we received an ID
$Id = (int) $_GET['id'];

// create the query
$sql = "DELETE FROM photo_storage WHERE id = :id";

// prepare
$stmt = $pdo->prepare($sql);

// bind the correct variable
$stmt->bindParam(':id', $Id, PDO::PARAM_INT);

// execute
$stmt->execute();

// redirect back to home page
header("Location: index.php");
exit;
?>