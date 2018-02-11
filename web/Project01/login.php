<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="project01.css">
	<title>Login</title>
</head>
<body>
	<ul>
  		<li><a href="home.php">Home</a></li>
	</ul>	
	<h1>Login</h1>
	
	<form method="post" action="login_check.php">
	<div id="login_user" class="form-div">Username: <input type="text" name="Username"> </div> <br/>
	<div id="login_pass" class="form-div">Password: <input type="password" name="Password"> <br/>
	<?php  
		if (isset($_SESSION['failed_login']) && $_SESSION['failed_login']) {
			print "<p id=\"login_error\">Your username or password was invalid.</p>\n";
			$_SESSION['failed_login'] = false;
		}
	?>
	</div> <br/>
	<br/>
	<div style="text-align: center;"><input type="submit" value="Login" class="black-button" style="text-align: center;"></div><br/>
	</form>
</body>
</html>
