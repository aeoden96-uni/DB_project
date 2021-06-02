<?php 
require_once __DIR__ . '/_header.php'; 
?>
<br>
<b>Welcome - Sign up to the shop</b>


<div class="form_container">
	<form  method="post" action="index.php?rt=start/signupResult">
    <br>
    <div class="form_container_smaller">
      <h2 style="text-align:center">Register</h2>
          
      <a class="form_button" href="index.php?rt=start">Return</a>	
      <input class="form_input" type="username" name="username" placeholder="Username" required>
      <input class="form_input" type="password" name="password" placeholder="Password" required>
      <input class="form_input" type="email" name="email" placeholder="Email" required>
      <input class="form_button" type="submit" value="Sign Up"> 
    </div>
    <br><br>
  </form>
</div>