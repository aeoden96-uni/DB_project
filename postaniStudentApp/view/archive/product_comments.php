<?php

require_once __DIR__ . '/_header.php';
require_once __DIR__ . '/addons/_navigation_pane.php';

function stars($value){
    $starValue=100-$value/5*100; 
    $star='<img style="clip-path: inset(0  '.(int)$starValue .'% 0 0);"  src="view/images/star.png"  width="100" height="20">';
    return $star;
}
?>


<div class="form_container">
    <div class="form_container_smaller">
        <p class="form_button">Product ID: <?php echo $myProduct->product_id; ?></p>
        <p class="form_button"><?php echo $myProduct->name; ?></p>
        <p class="form_button">Seller ID:<?php echo $myProduct->seller_id; ?></p>
    </div>
</div>

<br><center>Comments</center><br>


<?php
include __DIR__ . '/list_transactions.php';
?>





