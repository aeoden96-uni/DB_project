
<?php include __DIR__ . '/../_header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?rt=ucenik">Dashboard</a></li>
        <li class="breadcrumb-item active">My Info</li>
    </ol>
</nav>
<h1 class="h2">Faculty admin info</h1>
<p>This is your admin information.</p>


<!-- DEFINES ELEMENTS ON SAME HORIZONTAL LEVEL --->
<div class="row">
    <div class="col-12 col-xl-8 mb-4 mb-lg-0">
        <div class="card">
            <h5 class="card-header">Faculty details</h5>
            <div class="card-body">
                                 
                
                <h5 class="card-title">Factors</h5>
                <p class="card-text">Croatian -  <?php echo $faks->uvjeti->hrvatski;?>x</p>
                <p class="card-text">English -  <?php echo $faks->uvjeti->engleski;?>x</p>
                <p class="card-text">Mathematics -  <?php echo $faks->uvjeti->matematika;?>x</p>

                <h5 class="card-title">Additional required subjects</h5>
                <p class="card-text">Subject -  <?php echo $faks->uvjeti->izborni;?></p>

                <h5 class="card-title">Additional points for competitions</h5>
                <p class="card-text">Subject -  <?php echo $faks->uvjeti->natjecanje;?></p>

                <h5 class="card-title">Quota</h5>
                <p class="card-text">Quota -  <?php echo $faks->kvota;?></p>

               


            </div>
        </div> 
    </div>


    <div class="col-12 col-xl-4">
        <div class="card">
            <h5 class="card-header">Info for admin : <?php echo $faks->admin_username;?><h5>
            <div class="card-body">
              <h5 class="card-title">Username</h5>
              <p ><?php echo $faks->admin_username;?></p>
              <h5 class="card-title">OIB</h5>
              <p ><?php echo $faks->oib;?></p>
              <h5 class="card-title">Faculty name</h5>
              <p ><?php echo $faks->naziv;?></p>

            </div>
        </div>
    </div>
</div>


<?php include __DIR__ . '/../_footer.php'; ?>