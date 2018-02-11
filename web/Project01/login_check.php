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

	$username = $_POST['Username'];
	$password = $_POST['Password'];
	$URL;

	$stmt = $db->prepare("SELECT id FROM users WHERE username=:name AND password=:pass");
	$stmt->bindValue(':name', $username, PDO::PARAM_STR);
	$stmt->bindValue(':pass', $password, PDO::PARAM_STR); 
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
		$URL = "https://afternoon-coast-14408.herokuapp.com/Project01/home.php";
		$_SESSION['username'] = $username;
		$_SESSION['uID'] = $rows[0]['id'];
		header("Location: " . $URL);
		exit();		
	}

 ?>