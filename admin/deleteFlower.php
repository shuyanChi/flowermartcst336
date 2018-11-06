<?php
session_start();

include '../inc/dbConnection.php';
$dbConn = startConnection("tp_flowers");
include '../inc/functions.php';
validateSession();

$sql = "DELETE FROM `flowers` WHERE flower_Id = '" . $_GET['flowerId']."'";
$stmt=$dbConn->prepare($sql);
$stmt->execute();

header("Location: adminPage.php");



?>