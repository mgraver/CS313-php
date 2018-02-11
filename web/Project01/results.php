<?php 
	session_start();

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

	$search = $_GET['search'];

	$stmt = $db->prepare("SELECT name, description, id FROM recipes WHERE name=:search");
		$stmt->bindValue(":search", $search, PDO::PARAM_STR);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (empty($rows)) 
		{
			$_SESSION['failed_search'] = true; 
			$URL = "https://afternoon-coast-14408.herokuapp.com/Project01/home.php";
			header("Location: " . $URL);
			exit();		
		}
		else
		{
			$recipe_id = $rows[0]['id'];
			$URL = "https://afternoon-coast-14408.herokuapp.com/Project01/recipe.php?recipeID=$recipe_id";
			header("Location: " . $URL);
			exit();	
		}
 ?>

<!-- Will impliment a result padge when full text search funtionality is working.-->
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Results</title>
 </head>
 <body>
 
 </body>
 </html>