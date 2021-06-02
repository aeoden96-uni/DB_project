<br>
<div class="personalProductList">
	<table class="productTable">


		<?php

			
		foreach ( $myProductList as $product)
		{

			echo '<tr>' .
			     	'<td><a href="index.php?rt=product/'  . $product->product_id .  '">' . $product->name . '</a></td>' .
			     	'<td><a href="index.php?rt=main/'  . $product->seller_id .  '">Seller page '    . '</a></td>' .
				'</tr>'.
				 '<tr>'.
				 	 '<td>$' . $product->price . '</td>' .
					 '<td> '  .   stars($product->score). 'Sold: '.strval($product->sold). '</td>' .
			     '</tr>'.
				 '<tr class="bottom_cell_row">'.
				 	'<td colspan="2">' . $product->description . '</td>' ;
			
		}

		?>
	</table>


</div>