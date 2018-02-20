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

	$param = "%{$_GET['search']}%";
	$stmt = $db->prepare("SELECT name, description, id FROM recipes WHERE name LIKE ?");
	$stmt->bindValue(1, $param, PDO::PARAM_STR);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (empty($rows)) 
		{
			$_SESSION['failed_search'] = true; 
			$URL = "http://localhost/project01/home.php";
			header("Location: " . $URL);
			exit();		
		}
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<link rel="stylesheet" href="project01.css">
 	<title>Results</title>
 </head>
 <body>
 	<ul>
  		<li><a href="home.php">Home</a></li>
	</ul>
 	<h1> Recipes </h1>
 	<table>
 		<tr>
 			<th> Name </th>
 			<th> Description </th>
 		</tr>
			<?php 
				foreach ($rows as $row) 
				{
					$name = $row['name'];
					$description = $row['description'];
					$recipe_id = $row['id'];

					print("<tr>\n");
					print("<td><a href=\"recipe.php?recipeID=$recipe_id\">$name</a></td>");
					print("<td><p>$description</p></td>");
					print("</tr>\n");
				}
			?>
		</table>
 </body>
 </html>