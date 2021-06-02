<?php
require_once __DIR__ . '/_header.php';

?>

<p>Guest view</p>

<a href="index.php?rt=start/logout">Login or make an account</a> to shop here.
<br>

<br>
<div class="personalProductList">
	<table class="productTable">

		<?php 
			
		foreach ( $myProductList as $product)
		{	

			echo '<tr>' .
			     	'<td><b>' . $product->name . '</b></td>' .
			     	'<td></td>' .
				'</tr>'.
				 '<tr>'.
				 	 '<td>' . $product->price . '</td>' .
					 '<td></td>' .
			     '</tr>'.
				 '<tr>'.
				 	'<td colspan="2">' . $product->description . '</td>' .	
				'<tr>' 
				 ;
			
		}

		?>
	</table>
</div>