<!DOCTYPE html>
<html>
<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

	<!------ Include the above in your HEAD tag ---------->
</head>
<body>
<script>

function yesno(thecheckbox, thelabel,checkbox_conditions) {

	console.log(thecheckbox);
	console.log(thelabel);
	
    
    var checkboxvar = document.getElementById(thecheckbox);
    var labelvar = document.getElementById(thelabel);
	var condvar = document.getElementById(checkbox_conditions);
	
    if (!checkboxvar.checked) {
        labelvar.innerHTML = "Već imam račun";
		condvar.style.display = "none";
		document.getElementById("korisnik_uvjeti_label").innerHTML = "";

		
    }
    else {
        labelvar.innerHTML = "Nemam račun, izradi ga sad";
		document.getElementById("korisnik_uvjeti_label").innerHTML = " Prihvaćam uvjete i politiku privatnosti";
		condvar.style.display = "block";
		
		
    }
}
</script>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">


<div class="container">
	<br>  <h3 class="text-center">Postani student<sup>2.0</sup></h3>
	<hr>

	<div class="row">
	<aside class="col-sm-4">
	<p>Login za učenike</p>

	<div class="card">
	<article class="card-body">
		<!--<a href="" class="float-right btn btn-outline-primary">Sign up</a>-->
		<h4 class="card-title mb-4 mt-1">Učenik</h4>

		<hr>
		<form action="index.php?rt=start/loginCheckUcenik" method="post">
			<!--<div class="form-check form-switch">
			  <input onclick="yesno('korisnik_checkbox','korisnik_checkbox_label','korisnik_uvjeti');" class="form-check-input" type="checkbox" name="korisnik_checkbox"  id="korisnik_checkbox">
			  <label name="korisnik_checkbox_label" style="margin-bottom:10px;" class="form-check-label" id="korisnik_checkbox_label" for="korisnik_checkbox">Već imam račun</label>
			</div>-->
			<div class="form-group">
				<input style="margin-bottom:10px;" name="username" class="form-control" value="57816521120" placeholder="OIB" >
				
				<input style="margin-bottom:10px;"  name="password" class="form-control" value="Lozinka63" placeholder="******" type="password">
			
				<button type="submit" class="btn btn-primary btn-block"> Prijava  </button>
				
				
			</div> <!-- form-group// -->  
					
			                                                            
		</form>
	</article>
	</div> <!-- card.// -->

	</aside> <!-- col.// -->
	<aside class="col-sm-4">
	<p>Login za fakultete</p>

	<div class="card">
	<article class="card-body">
		<!--<a href="" class="float-right btn btn-outline-primary">Sign up</a>-->
		<h4 class="card-title mb-4 mt-1">Fakultet</h4>

		<hr>
		<form action="index.php?rt=start/loginCheckFaks" method="post">
			
			<div class="form-group">
				<input style="margin-bottom:10px;" name="username" class="form-control" value="admin.victoria" placeholder="Admin username" >
				
				<input style="margin-bottom:10px;" name="password" class="form-control" value="USO8sxUP" placeholder="******" type="password">
				
				<button type="submit" class="btn btn-primary btn-block"> Prijava  </button>
				                                
			</div> <!-- form-group// -->  
					
			                                                            
		</form>
	</article>
	</div> <!-- card.// -->

	</aside> <!-- col.// -->
	<aside class="col-sm-4">
	<p>Login za admine</p>

	<div class="card">
	<article class="card-body">
		<!--<a href="" class="float-right btn btn-outline-primary">Sign up</a>-->
		<h4 class="card-title mb-4 mt-1">Administrator</h4>

		<hr>
		<form action="index.php?rt=start/loginCheckAdmin" method="post">
			
			<div class="form-group">
				<input style="margin-bottom:10px;" name="username" class="form-control" value="admin.jakara" placeholder="Admin username" >
				
				<input style="margin-bottom:10px;" name="password" class="form-control" value="QgJegvBFRDX" placeholder="******" type="password">
				
				<button type="submit" class="btn btn-primary btn-block"> Prijava  </button>
				                                   
			</div> <!-- form-group// -->  
					
			                                                            
		</form>
	</article>
	</div> <!-- card.// -->

	</aside> <!-- col.// -->
	</div> <!-- row.// -->

</div> 
<!--container end.//-->

<br><br><br>


<!--<article class="bg-secondary mb-3">  
	<div class="card-body text-center">
		<h4 class="text-white">HTML UI KIT <br> Ready to use Bootstrap 4 components and templates </h4>
		<p class="h5 text-white"> for Ecommerce, marketplace, booking websites 
		and product landing pages</p>   <br>
		<p><a class="btn btn-warning" target="_blank" href="http://bootstrap-ecommerce.com/"> Bootstrap-ecommerce.com  
		<i class="fa fa-window-restore "></i></a></p>
	</div>
	<br><br><br>
</article>-->



</body>
</html>