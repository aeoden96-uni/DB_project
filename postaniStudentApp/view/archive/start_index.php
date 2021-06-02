<?php 
require_once __DIR__ . '/_header.php'; 
?>


<body>


<div class="form_container">
  <form action="index.php?rt=start/login"  method="post">

    <div class="form_container_smaller">
        <h2 style="text-align:center">Login to the store</h2>
        

        <input class="form_input" type="text" name="username" placeholder="Username" required>
        <input class="form_input" type="password" name="password" placeholder="Password" required>
        <input class="form_button" type="submit" value="Login">
        <a class="form_button" href="index.php?rt=start/guestLogin">Login as guest </a>
    </div>
  </form>
</div>

<div class="form_bottom_container">
  <div class="form_container_smaller">

    <a class="form_button" href="index.php?rt=start/signup"  >Sign up</a>

    <form action="index.php?rt=start/reciveRegSeq"  method="post">
      <input class="form_input" type="text" name="reqSeq" placeholder="Got register sequence? Enter it here" required>
      <input class="form_button" type="submit" value="Send">

    </form>
  </div>
</div>


