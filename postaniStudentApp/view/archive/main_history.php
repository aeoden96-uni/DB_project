<?php

require_once __DIR__ . '/_header.php';
require_once __DIR__ . '/addons/_navigation_pane.php';

function stars($value){
    $starValue=100-$value/5*100; 
    $star='<img style="clip-path: inset(0  '.(int)$starValue .'% 0 0);"  src="view/images/star.png"  width="100" height="20">';
    return $star;
}
?>

<br>

<?php
    include __DIR__ . '/list_transactions _history.php';
?>