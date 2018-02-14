<?php 
	session_start();

	if (!isset($_SESSION['uID'])) 
	{
		$URL = "https://afternoon-coast-14408.herokuapp.com/Project01/login.php";
		header("Location: " . $URL);
		exit();
	}

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

	$rID = $_GET['recipeID'];
	$stmt = $db->prepare("INSERT INTO favorite (recipe_ID) VALUES (:rID)");
	$stmt->bindValue(':rID', $rID, PDO::PARAM_INT);
	$stmt->execute();

	$favoriteID = $db->lastInsertID('favorite_id_seq');

	$stmt = $db->prepare("INSERT INTO user_favorite (User_ID, Favorite_ID) VALUES (:uID, :fID)");
	$stmt->bindValue(':uID', $_SESSION['uID'], PDO::PARAM_INT);
	$stmt->bindValue(':fID', $favoriteID, PDO::PARAM_INT);
	$stmt->execute();

	$URL = "https://afternoon-coast-14408.herokuapp.com/Project01/favorite.php";
	header("Location: " . $URL);
	exit();
 ?>