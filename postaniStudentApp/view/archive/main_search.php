<?php 

require_once __DIR__ . '/_header.php'; 
require_once __DIR__ . '/addons/_navigation_pane.php';
?>



<div class="form_container">
  <form action="index.php?rt=product/searchResult"  method="post">

    <div class="form_container_smaller">
        <h2 style="text-align:center">Search</h2>
        
        <input class="form_input" type="text" name="searchTerm" placeholder="Search"/> 

		<select class="form_input" name="searchType" >
			<option value="user_id" >UserID</option>
			<option value="prod_id" >ProductID</option>
			<option value="user_nm" >Username</option>
			<option value="prod_nm" >Product name</option>
		</select>

        <input class="form_button" type="submit" value="Search">


		



    </div>
  </form>
</div>
