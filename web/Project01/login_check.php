<?php
	session_start();

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

	if ($_POST['submit'] == 'Login') 
	{
		$username = $_POST['Username'];
		$password = $_POST['Password'];
		$URL;

		$stmt = $db->prepare("SELECT id, password FROM users WHERE username=:name");
		$stmt->bindValue(':name', $username, PDO::PARAM_STR);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (empty($rows))
		{
			$_SESSION['failed_login'] = true;
			$URL = "https://afternoon-coast-14408.herokuapp.com/Project01/login.php";
			header("Location: " . $URL);
			exit();
		}
		else
		{
			if (password_verify($password, $rows[0]['password'])) 
			{
				$URL = "https://afternoon-coast-14408.herokuapp.com/Project01/home.php";
				$_SESSION['username'] = $username;
				$_SESSION['uID'] = $rows[0]['id'];
				header("Location: " . $URL);
				exit();		
			}
			else
			{
				$_SESSION['failed_login'] = true;
				$URL = "https://afternoon-coast-14408.herokuapp.com/Project01/login.php";
				header("Location: " . $URL);
				exit();
			}
		}
	}
	else  #Create a new user
	{
		$username = $_POST['Username'];
		$password = $_POST['Password'];
		$URL;

		$hashedPass = password_hash($password, PASSWORD_DEFAULT);

		$stmt = $db->prepare("SELECT id FROM users WHERE username=:name");
		$stmt->bindValue(':name', $username, PDO::PARAM_STR);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (!empty($rows) || empty($password)) 
		{
			$_SESSION['failed_create'] = true;
			$URL = "https://afternoon-coast-14408.herokuapp.com/Project01/login.php";
			header("Location: " . $URL);
			exit();
		} 
		else
		{
			$stmt = $db->prepare("INSERT INTO users (Username, Password) VALUES (:usnm, :psswd)");
			$stmt->bindValue(':usnm', $username, PDO::PARAM_STR);
			$stmt->bindValue(':psswd', $hashedPass, PDO::PARAM_STR);
			$stmt->execute();

			$_SESSION['username'] = $username;
			$_SESSION['uID'] = $db->lastInsertID('users_id_seq');
			$URL = "https://afternoon-coast-14408.herokuapp.com/Project01/home.php";
			header("Location: " . $URL);
			exit();	
		}
	}

 ?>