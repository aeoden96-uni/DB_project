<div class="commentContainer">
    <?php
    foreach ( $myProductList as $product)
    {
        if($product->rating==NULL && $product->comment==NULL){
            continue;
        }

        echo 
        '<div class="comment form_container">'.
            '<div class="commentBUYERID">'.
                '<p><a href="index.php?rt=main/'. $product->id_user.'">Buyer ID: ' . $product->id_user . '</a></p>'.
            '</div>'.
            '<div class="commentPRODUCTID">'.
                '<p><a href="index.php?rt=product/'. $product->id_product.'">Product ID: ' . $product->id_product . '</a></p>'.
            '</div>'.
            '<div class="commentRATING">'.
                '<p>Rating: ' .  $product->rating . '</p>'.
            '</div>'.
            '<div class="commentSTARS">'.
                '<p>' . stars($product->rating)  . '</p>'.
            '</div>'.
            '<div class="commentTEXT">'.
                '<p>' . $product->comment . '</p>'.
            '</div>'.
        '</div>';
    }
    ?>
</div>