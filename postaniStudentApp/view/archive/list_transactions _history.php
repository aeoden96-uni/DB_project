<div class="commentContainer">
    <?php
    foreach ( $myProductList as $product)
    {
        if($product->rating==NULL && $product->comment==NULL){
            $form=
            '<form action="index.php?rt=main/addComment"  method="post">'.
            '<input type="hidden"  name="product_id" value="'.$product->id_product .'">'.
            '<input type="number" name="rating" placeholder="rating"><br>'.
            '<textarea type="textarea" name="comment" placeholder="add your comment"></textarea><br>'.
            '<input type="submit" value="Add your comment"> </form>';
        }
        else{
            $form='Rating: '. $product->rating;
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
                '<p>' .  $form . '</p>'.
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