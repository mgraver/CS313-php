<?php session_start(); 
	  $zip = htmlspecialchars($_POST['zip']);
	  $street = htmlspecialchars($_POST['street']);
	  $city = htmlspecialchars($_POST['city']);
	  $state = htmlspecialchars($_POST['state']);
?>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="P3.css">
	<title>Receipt</title>
</head>
<body>
	<h1 style="text-align: center;">Thank You</h1>
	 <div style="margin: 0 auto; width: 60%; border: solid 5px #F19F4D; 
	 background-color: #D9D9D9; padding: 10px;">

	<table id="reset" style="margin: 0 auto;" cellpadding="10px;">
			<?php
				foreach ($_SESSION['item_count'] as $key => $value) {
					if ($value != 0) {
						print("<tr>\n");

						print("<td>".$_SESSION['item_name'][$key]."</td>\n");
						print("<td>".$_SESSION['item_count'][$key]."</td>\n");
						printf("<td> %.02f</td>\n", $_SESSION['item_prices'][$key] * $_SESSION['item_count'][$key]);
						print("<tr>\n");
					}
				}
				?>
		</table>
		
		<br>

		<p style="margin-left: 95px;"> Total: $
		<?php 
			$Total = 0;
			foreach ($_SESSION['item_count'] as $key => $value) {
				$Total += $value * $_SESSION['item_prices'][$key];
			}
			printf("%.02f", $Total);
		?></p>
		<p style="margin-left: 95px;">
			Shipped To:<br><br>
			<?php
				echo $street . " " . $zip . " " . $city . " " . $state;
			?>
		</p>
	</div>
		
</body>
</html>

<?php
session_unset();
session_destroy();
?>