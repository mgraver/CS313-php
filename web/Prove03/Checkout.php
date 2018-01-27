<?php session_start(); ?>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="P3.css">
	<title>Final Checkout</title>
</head>
<body>
	<h1 style="text-align: center;">Final Checkout</h1>
	 <div style="margin: 0 auto; width: 60%; border: solid 5px #F19F4D; 
	 background-color: #D9D9D9; padding: 10px;">

		<form action="confirmation.php" style="height: 150px;" method="post">
			<fieldset>
			<legend>Customer Info:</legend>
			<div style="float: left;">Street: <textarea rows="1" style="resize: none; width: 150px; margin-right: 150px;" 
				name="street"></textarea>Zip: <textarea rows="1" style="resize: none; width: 150px;" 
				name="zip"></textarea> </div>
			<div style="float: left;">City: <textarea rows="1" style="resize: none; width: 150px; margin-right: 150px;" 
				name="city"></textarea>
				State: <textarea rows="1" style="resize: none; width: 150px;" 
				name="state"></textarea></div>
		</fieldset>
			<br>
			<input type="submit" name="submit" value="Purchase" id="cart" style="float:right;">
			<a href="Cart.php" id="cart" style="width: 60px; float: left;">To Cart</a>
		</form>
	</div>
		
</body>
</html>