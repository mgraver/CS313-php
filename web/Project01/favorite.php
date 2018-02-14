<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="project01.css">
	<title>Your Favorites</title>
</head>
<body>
	<?php  
		$dbUrl = getenv('DATABASE_URL');

		if (empty($dbUrl)) {
	 	// example localhost configuration URL with postgres username and a database called cs313db
 		$dbUrl = "postgres://limited:limitd@localhost:5432/project01";
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
  		<li><a href="home.php">Home</a></li>
	</ul>	
	<h1>Your Favorites List</h1>
	
		<table>
			<?php 
				$stmt = $db->prepare("SELECT Name, Description, r.ID, f.id AS favorite_id FROM users u JOIN user_favorite uf ON :id = u.id
					JOIN favorite f ON uf.Favorite_ID = f.ID JOIN recipes r ON f.Recipe_ID = r.ID");
				$stmt->bindValue(":id", $_SESSION['uID'], PDO::PARAM_INT);
				$stmt->execute();
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				
				foreach ($rows as $row) 
				{
					$name = $row['name'];
					$description = $row['description'];
					$recipe_id = $row['id'];
					$favorite_id = $row['favorite_id'];

					print("<tr>\n");
					print("<td><a href=\"recipe.php?recipeID=$recipe_id&fID=$favorite_id\">$name</a></td>");
					print("<td>$description</td>");
					print("</tr>\n");
				}
			?>
		</table>

</body>
</html>