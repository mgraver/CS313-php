<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="project01.css">
	<title>Use My Recipes</title>
</head>
<body>
	<?php  
		$dbUrl = getenv('DATABASE_URL');

		if (empty($dbUrl)) {
 		// example localhost configuration URL with postgres username and a database called cs313db
 		$dbUrl = "postgres://limited:limited@localhost:5432/project01";
		}

		$dbopts = parse_url($dbUrl);

		$dbHost = $dbopts["host"];
		$dbPort = $dbopts["port"];
		$dbUser = $dbopts["user"];
		$dbPassword = $dbopts["pass"];
		$dbName = ltrim($dbopts["path"],'/');

		try {
		 $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
		}
		catch (PDOException $ex) {
		 print "<p>error: $ex->getMessage() </p>\n\n";
		 die();
		}
	?>

	<ul>
	<?php 
		if (!isset($_SESSION['username'])) 
		{
			print('<li> <a href="login.php">Login</a> </li>');
		}
		else
		{
			print(" <li id=\"welcome\">Welcome, ".  $_SESSION['username'] . "</li>");
			
			print('<li> <a href="favorite.php">Favorites</a> <li>');
			print('<li> <a href="logout.php">Logout</a> </li>');
		}
	 ?>
	</ul>
	<h1 style="margin-top: 75px;">Use My Recipes</h1>
	 <br/>
	 <form action="results.php" method="get" style="margin-top: 50px;">
	 	<div class="form-div">
		 	<input type="text" name="search" size="50" placeholder="Find your recipe...">
		 	<input type="submit" value="Search" class="black-button"> <br/>
	 	</div>	
	 	<?php  
	 		if (isset($_SESSION['failed_search']) && $_SESSION['failed_search']) 
	 		{
	 			print "There were no results for your search.\n";
	 			$_SESSION['failed_search'] = false;
	 		}
	 	?>
	 </form>

</body>
</html>