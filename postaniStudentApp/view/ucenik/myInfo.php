
<?php include __DIR__ . '/../_header.php'; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?rt=ucenik">Dashboard</a></li>
        <li class="breadcrumb-item active">My Info</li>
    </ol>
</nav>
<h1 class="h2">User info</h1>
<p>This is the homepage of a simple admin interface which is part of a tutorial written on Themesberg</p>


<!-- DEFINES ELEMENTS ON SAME HORIZONTAL LEVEL --->
<div class="row">
    <div class="col-12 col-xl-8 mb-4 mb-lg-0">
        <div class="card">
            <h5 class="card-header">Test scores compared to peers</h5>
            <div class="card-body">
                <div id="traffic-chart"></div>
            </div>
        </div> 
    </div>


    <div class="col-12 col-xl-4">
        <div class="card">
            <h5 class="card-header">Info for user : ***</h5>
            <div class="card-body">
              <h5 class="card-title">Username</h5>
              <p class="card-text">Some username</p>
              <!--<p class="card-text text-success">2.5% increase since last month</p>-->
              <h5 class="card-title">OIB</h5>
              <p class="card-text">23564453123</p>

               
            </div>
        </div>
    </div>
</div>


<?php include __DIR__ . '/../_footer.php'; ?>