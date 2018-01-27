<?php
session_start();

$item_Key = $_GET["item"];
$_SESSION["item_count"][$item_Key]--;
$url = "https://afternoon-coast-14408.herokuapp.com/Prove03/Cart.php";
header("Location: ". $url);
exit();
?>