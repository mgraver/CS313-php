<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="project01.css">
	<title>Recipe</title>
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

			$recipeID = $_GET["recipeID"];

			$stmt = $db->prepare("SELECT name, rating, description FROM recipes WHERE id = :id");
			$stmt->bindValue(':id', $recipeID, PDO::PARAM_INT);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		?>
<ul>
  		<li><a href="home.php">Home</a></li>
  		<?php
  			if (isset($_GET['fID'])) 
  			{
  				$fID = $_GET['fID'];
  			 	print "<li><a href=\"remove_fav.php?fID=$fID\">Remove Favorite</a></li>";
  			} 
  		?>
</ul>	
<h1> <?php  print $rows[0]['name'];?> </h1> <br/>

<div>
<pre>
Rating: <?php  print $rows[0]['rating']; ?>


Description: <?php print $rows[0]['description']; ?>
</pre>
</div>

<div id="ingridents">
	<?php
		$stmt = $db->prepare("SELECT i.name, ri.amount, u.unit FROM recipe_ingrident ri JOIN ingredients i 
			ON ri.recipe_id = :rID AND ri.ingredient_id = i.id LEFT JOIN unit u ON ri.unit = u.id");
		$stmt->bindValue(':rID', $recipeID, PDO::PARAM_INT);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		print "Ingridents: <br/>\n";
		foreach ($rows as $row)
		{
			printf("%-25s  %-25d  %s\n", $row['name'], $row['amount'], $row['unit']);
		}
	?>
</div>

<div id="steps">
	<?php  
		$stmt = $db->prepare("SELECT recipe_steps FROM steps WHERE Recipe_ID = :id");
			$stmt->bindValue(':id', $recipeID, PDO::PARAM_INT);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	?>
	<pre> <?php print $rows[0]['recipe_steps']?> </pre>
</div>

<div class="form-div">
	<form action="add_to_favorite.php" method="get">

		<?php  
			$stmt = $db->prepare("SELECT f.Recipe_ID FROM users u JOIN user_favorite uf ON :uID = u.id
									JOIN favorite f ON uf.Favorite_ID = f.ID");
			$stmt->bindValue(':uID', $_SESSION['uID'], PDO::PARAM_INT);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$isFavorite = false;
			foreach ($rows as $row) 
			{
				if ($row['recipe_id'] == $recipeID)
					$isFavorite = true;
				
			}

			if (!$isFavorite) 
			{
				print "<input type =\"submit\" value=\"Add to Favorties\" class=\"black-button\"/>";
			}
		?>

		<input type="hidden" name="recipeID" <?php print "value=\"" . $recipeID . "\"";?>/>
	</form>
	
	<?php
		if (isset($_GET['fID']))
		{
			$favorite_id = $_GET['fID'];
			$stmt = $db->prepare("SELECT Comment FROM favorite WHERE id = :fID");
			$stmt->bindValue(':fID', $favorite_id, PDO::PARAM_INT);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

			print ("<form action=\"update_comment.php\" method=\"post\">");
			print ("<textarea rows=\"15\" cols=\"90\" name=\"comment\">\n");
			if (!empty($rows)) {
				print $rows[0]['comment'] . "\n";
			}
			print ("</textarea>\n <br/>\n");
			print("<input type=\"hidden\" value=\"$favorite_id\" name=\"fID\">");
			print("<input type=\"hidden\" value=\"$recipeID\" name=\"rID\">");
			print("<input type=\"submit\" value=\"Update\" class=\"black-button\">");
			print("</form>");
		}
	?>
</div>

</body>
</html>