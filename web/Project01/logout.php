<?php
session_start();
session_unset();
$URL = "http://localhost/project01/home.php";
header("Location: " . $URL);
exit();	
?>