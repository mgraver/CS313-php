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

<h1><?php  print $rows[0]['name']; ?></h1> <br/>
<div>
<pre>
Rating: <?php  print $rows[0]['rating']; ?>


Description: <?php print $rows[0]['description']; ?>
</pre>

<?php  
$stmt = $db->prepare("SELECT recipe_steps FROM steps WHERE Recipe_ID = :id");
	$stmt->bindValue(':id', $recipeID, PDO::PARAM_INT);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
</div>

<div id="steps">
	<pre> <?php print $rows[0]['recipe_steps']?> </pre>
</div>

</body>
</html>