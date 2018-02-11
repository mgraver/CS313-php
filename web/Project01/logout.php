<?php
session_start();
session_unset();
$URL = "https://afternoon-coast-14408.herokuapp.com/Project01/home.php";
header("Location: " . $URL);
exit();	
?>