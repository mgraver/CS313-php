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

			$favorite_ID = $_GET["fID"];

			$stmt = $db->prepare("DELETE FROM user_favorite WHERE favorite_id = :fID");
			$stmt->bindValue(':fID', $favorite_ID, PDO::PARAM_INT);
			$stmt->execute();

			$stmt = $db->prepare("DELETE FROM favorite WHERE id = :fID");
			$stmt->bindValue(':fID', $favorite_ID, PDO::PARAM_INT);
			$stmt->execute();

			$URL = "https://afternoon-coast-14408.herokuapp.com/Project01/favorite.php";
			header("Location: " . $URL);
			exit();
?>