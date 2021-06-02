<?php 


require_once __DIR__ . '/_header.php'; 
require_once __DIR__ . '/addons/_navigation_pane.php';

?>


<div class="form_container">
  <form action="index.php?rt=main/addResult"  method="post">

    <div class="form_container_smaller">
        <h2 style="text-align:center">Add product</h2>
        
        <input class="form_input" type="text" name="productName" placeholder="Product name" required/> 

		<textarea class="form_input" name="description" rows="3" cols="30" placeholder="Description" required></textarea>

        <input  class="form_input" type="number" name="price" step=".01" placeholder="Price" required/>  

        <input class="form_button" type="submit" value="Add">

    </div>
  </form>
</div>



