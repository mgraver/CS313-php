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

			$comment = $_POST["comment"];
			$fav_id = $_POST["fID"];
			$r_id = $_POST["rID"];

			$stmt = $db->prepare("UPDATE favorite SET comment = :C WHERE id = :id");
			$stmt->bindValue(':id', $fav_id, PDO::PARAM_INT);
			$stmt->bindValue(':C', $comment, PDO::PARAM_STR);
			$stmt->execute();

			$URL = "https://afternoon-coast-14408.herokuapp.com/Project01/recipe.php?recipeID=$r_id&fID=$fav_id";
			header("Location: " . $URL);
			exit();
?>