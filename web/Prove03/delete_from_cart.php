<?php
session_start();

$item_Key = $_GET["item"];
$_SESSION["item_count"][$item_Key]--;
$url = "http://localhost/Prove03/Cart.php";
header("Location: ". $url);
exit();
?>