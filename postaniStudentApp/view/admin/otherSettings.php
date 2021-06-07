
<?php include __DIR__ . '/../_header.php'; ?>


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?rt=ucenik">Dashboard</a></li>
        <li class="breadcrumb-item active">Other</li>
    </ol>
</nav>
<h1 class="h2">Other settings</h1>
<p>Here you can change some of global variables.</p>


<div class="col-12 col-xl-4 mb-4 mb-lg-0">
<form action="index.php?rt=admin/otherSettingsCheck" method="post">
			
    <div class="form-group">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">Lock date</span>
            </div>
            <input type="text" name="lockDate" class="form-control" id="basic-url" placeholder="<?php echo $lockDateString; ?>" aria-describedby="basic-addon3">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">Results date</span>
            </div>
            <input type="text" name="resultDate" class="form-control" id="basic-url" placeholder="<?php echo $resultDateString; ?>" aria-describedby="basic-addon3">
        </div>

       
        
    
        <button type="submit" class="btn btn-primary btn-block"> Change  </button>
        
        
    </div> <!-- form-group// -->  
					
			                                                            
</form>
</div>

<?php include __DIR__ . '/../_footer.php'; ?>