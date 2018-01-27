<?php session_start(); ?>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="P3.css">
	<title>Cart</title>
</head>
<body>
	<h1 style="text-align: center;">Your Cart </h1>
	 <div style="margin: 0 auto; width: 60%; border: solid 5px #F19F4D; 
	 background-color: #D9D9D9; padding: 10px;">

	<table id="reset" style="margin: 0 auto;" cellpadding="10px;">
			<tr>
				<th>Item</th>
				<th>Count</th>
				<th>Price</th>
			</tr>
			<?php
				foreach ($_SESSION['item_count'] as $key => $value) {
					if ($value != 0) {
						print("<tr>\n");

						print("<td>".$_SESSION['item_name'][$key]."</td>\n");
						print("<td>".$_SESSION['item_count'][$key]."</td>\n");
						printf("<td> %.02f</td>\n", $_SESSION['item_prices'][$key] * $_SESSION['item_count'][$key]);
						print("<td> <a class=\"remove\" href=\"delete_from_cart.php?item=". $key ."\">Remove</a> </td>\n");
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

		<form action="Prove03.php" style="height: 50px;">
			<input type="submit" name="submit" value="Browse" id="cart" style="float: left;">
			<a href="Checkout.php" id="cart" style="width: 75px; float: right;">Checkout</a>
		</form>
	</div>
		
</body>
</html>