<?php header("Content-type: text/html\n\n"); ?>


<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="Prove02.css">
	<meta charset="utf-8"/>
	<title>Thanks for Visiting</title>
</head>
<body>
	<h2 style="text-align: center;">Thank You!</h2>
	 <div id="baseDiv">
	 <div id="contentDiv">
	 	<?php
	 		$response = $_POST["response"];
	 		if ($response == "Yes") {
	 			print("<p> I am glad you liked my page.  Any comments you have left for me will be taken into consideration
	 						for further imporvement.  I hope that you visit the page again in the future.  Thank you! </p>");
	 		} else {
	 			print("<p> $response I am sorry that you did not like my page.  I will take your comments into carful consideration
	 				       when revamping the site.  Visit again in the future to see your suggestions implemented.</p>");
	 		}
	 	?>
	</div>
	</div>
		
</body>
</html>