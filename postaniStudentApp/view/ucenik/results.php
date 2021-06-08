
<?php include __DIR__ . '/../_header.php';






?>


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?rt=ucenik">Dashboard</a></li>
        <li class="breadcrumb-item active">Results</li>
    </ol>
</nav>
<h1 class="h2">Results</h1>
<p>Here is your result.</p>


<div class="row">
    <div class="col-12 col-xl-8 mb-4 mb-lg-0">

        <div style="margin-bottom: 10px;" class="card">
            <h5 class="card-header">Result status <span class="text-<?php echo $upisao? "success" : "warning"; ?>"><?php echo $upisao? "ENROLLED" : "NOT ENROLLED"; ?></span></h5>
            <div class="card-body">
                <p><?php echo $upisao? ("Congratulations,you got enrolled in " .$faks->naziv . ".") :
                 "Unforunately,you didn't enroll to any faculties at this point.";?></p>
                
            </div>
        </div>
       
        
    </div>





    <div <?php if(!$upisao) echo 'style="display: none;"';?> class="col-12 col-xl-4" id="faculty_info">
        <div class="card">
            <h5 class="card-header">Faculty information</h5>
            <div class="card-body">
              <h5 class="card-title">Name</h5>
              <p class="card-text"><?php echo $faks->naziv;?></p>
              <h5 class="card-title">OIB</h5>
              <p class="card-text"><?php echo $faks->oib;?></p>
              <h5 class="card-title">You will get email from the admin with more info:</h5>
              <p class="card-text"><?php echo $faks->admin_username;?></p>


               
            </div>
        </div>
    </div>
</div>

<?php





include __DIR__ . '/../_footer.php'; ?>