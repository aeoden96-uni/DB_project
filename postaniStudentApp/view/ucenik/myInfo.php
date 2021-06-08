
<?php include __DIR__ . '/../_header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?rt=ucenik">Dashboard</a></li>
        <li class="breadcrumb-item active">My Info</li>
    </ol>
</nav>
<h1 class="h2">User info</h1>
<p>This is your personal info.</p>


<!-- DEFINES ELEMENTS ON SAME HORIZONTAL LEVEL --->
<div class="row">
    <div class="col-12 col-xl-8 mb-4 mb-lg-0">

        <div style="margin-bottom: 10px;" class="card">
            <h5 class="card-header">State exams</h5>
            <div class="card-body">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped" role="progressbar" 
                        style="width: <?php echo (int)(($ocjene->prosjek)/5*100);?>%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="5">Prosjek (srednja škola) <?php echo $ocjene->prosjek;?>
                    </div>
                </div>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped bg-info" role="progressbar" 
                    style="width: <?php echo (int)(($ocjene->matematika)/5*100);?>%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="5">Matematika <?php echo $ocjene->matematika;?></div>
                </div>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped  " role="progressbar" 
                    style="width: <?php echo (int)(($ocjene->hrvatski)/5*100);?>%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="5">Hrvatski <?php echo $ocjene->hrvatski;?></div>
                </div>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped bg-info" role="progressbar" 
                    style="width: <?php echo (int)(($ocjene->engleski)/5*100);?>%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="5">Engleski <?php echo $ocjene->engleski;?></div>
                </div>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped  " role="progressbar" 
                    style="width: <?php echo (int)(($ocjene->izborni->ocjena)/5*100);?>%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="5">Izborni: <?php echo $ocjene->izborni->naziv . " ". $ocjene->izborni->ocjena;?></div>
                </div>
                
            </div>
        </div>
        <!--<div style="margin-bottom: 10px;" class="card">
            <h5 class="card-header">Test scores compared to peers</h5>
            <div class="card-body">
                <div id="traffic-chart"></div>
            </div>
        </div>--> 
        <div style="margin-bottom: 10px;"  class="card">
            <h5 class="card-header">Best place at state comeptitions</h5>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item list-group-item-success">
                    <?php echo $natjecanja->naziv;?> <span class="badge bg-dark"><?php echo $natjecanja->mjesto;?></span></li>
                   
                </ul>
            </div>
        </div>
        
    </div>





    <div class="col-12 col-xl-4">
        <div class="card">
            <h5 class="card-header">Info for user : <?php echo $user->ime;?></h5>
            <div class="card-body">
              <h5 class="card-title">Username</h5>
              <p class="card-text"><?php echo $user->username;?></p>
              <!--<p class="card-text text-success">2.5% increase since last month</p>-->
              <h5 class="card-title">Name</h5>
              <p class="card-text"><?php echo $user->ime;?></p>
              <h5 class="card-title">Surname</h5>
              <p class="card-text"><?php echo $user->prezime;?></p>
              <h5 class="card-title">Birth date</h5>
              <p class="card-text"><?php echo $user->datum_rodenja;?></p>

               
            </div>
        </div>
    </div>
</div>


<?php include __DIR__ . '/../_footer.php'; ?>