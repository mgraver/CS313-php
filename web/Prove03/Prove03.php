<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="P3.css">
	<title>Buy My Stuff</title>
	<?php
		//Setup session variables. 

		if (!isset($_SESSION['item_prices'])) {
			$iPrices = array('slinky' => 12.92, 'stick' => 18.99, 'beans' => 35.00, 'ring' => 110.00);
			$iCount = array('slinky' => 0, 'stick' => 0, 'beans' => 0, 'ring' => 0);
			$iName = array('slinky' => 'Slinky', 'stick' => 'Stick', 'beans' => "Magic Beans", 'ring' => "Magic Ring");
			$_SESSION['item_prices'] = $iPrices;
			$_SESSION['item_count'] = $iCount;
			$_SESSION['item_name'] = $iName;
		} 
		
		if (!isset($_SESSION['item_count'])) {
			$iCount = array('slinky' => 0, 'stick' => 0, 'beans' => 0, 'ring' => 0);
			$_SESSION['item_count'] = $iCount;
		} 

		if (!isset($_SESSION['item_name'])) {
			$iName = array('slinky' => 'Slinky', 'stick' => 'Stick', 'beans' => "Magic Beans", 'ring' => "Magic Ring");
			$_SESSION['item_name'] = $iName;
		} 

		$total = 0;
		foreach ($_SESSION['item_count'] as $key => $value) {
			$total += $value;
		}
	?>
</head>
<body>
	<h1>Buy My Stuff</h1>

	<form id="catlogForm" onsubmit="return ValidateForm()"
	action="Cart.php" onreset="resetForm()" method="post">
	<div id="headerBar">
			<input type="submit" value= <?php echo "\"Cart: " . $total . "\""?> id="cart">
	</div>
		<h2 style="text-align: center;">Products</h2>
		<table id="products">
			<tr>
				<td>
					<img src="slinky.jpeg" height="150" width="150"/>
				</td>

				<td>
					<p>
						Your favortie kid toy is back. This slinky is not only made
						out of steel but has been enchanted by a 1000 wizards to
						keep you entertained for hours.  This great toy is great
						for kids and adults.  Bring your happiness back with our
						Magic Slinky.
					</p>
				</td>

				<td>$12.92
					<a href="add_to_cart.php?item=slinky">Add</a>
				</td>
			</tr>

			<tr>
				<td>
					<img src="stick.jpg" height="150" width="150"/>
				</td>

				<td>
					<p>
						Mother natures greatest invention. The Stick!
						This is the greatest invention in the world
						if you have the imaginative powers to wield
						it. Fight evil through melee combat or even
						create a new cuisine, all is possible with this
						stick.
					</p>
				</td>

				<td>$18.99
					<a href="add_to_cart.php?item=stick">Add</a>
				</td>
			</tr>

			<tr>
				<td>
					<img src="magic-beans.jpg" height="150" width="150"/>
				</td>

				<td>
					<p>
						You know the old man from jack and the beanstalk.
						Well we found him and took all of his magic beans.
						Have you ever wanted to fight giants, Get really
						rich from golden eggs, or even fall asleep while
						listening to a magical harp?  Well that time is
						now! Buy your magic beans today!
					</p>
				</td>

				<td>$35.00
					<a href="add_to_cart.php?item=beans">Add</a>
				</td>
			</tr>

			<tr>
				<td>
					<img src="One-Ring.jpg" height="150" width="150"/>
				</td>

				<td>
					<p>
						Want to turn invisible and look stylish at the
						same time.  Well we found the ring to do it.
						Not only does it look good but it turns you invisible
						too.  We dont know what the writing says but it looks
						cool.  This ring does have some side effects.  Addiction
						, hair loss, multiple personality disorder, and possibly
						seeing a big firey eye.
					</p>
				</td>

				<td>$110.00
					<a href="add_to_cart.php?item=ring">Add</a>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
