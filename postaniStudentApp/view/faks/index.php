
<?php include __DIR__ . '/../_header.php'; ?>



<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
</nav>
<h1 class="h2">Dashboard</h1>
<p>This is the homepage of a simple admin interface which is part of a tutorial written on Themesberg</p>

<!--HORIZ CONTAINER
my-4 = MARGIN top bottom
-->
<div class="row my-4">

    <!--ONE LITTLE MODAL----->
    <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
        <div class="card">
            <h5 class="card-header">Customers</h5>
            <div class="card-body">
              <h5 class="card-title">345k</h5>
              <p class="card-text">Feb 1 - Apr 1, United States</p>
              <p class="card-text text-success">18.2% increase since last month</p>
            </div>
          </div>
    </div>
    <div class="col-12 col-md-6 mb-4 mb-lg-0 col-lg-3">
        <div class="card">
            <h5 class="card-header">Revenue</h5>
            <div class="card-body">
              <h5 class="card-title">$2.4k</h5>
              <p class="card-text">Feb 1 - Apr 1, United States</p>
              <p class="card-text text-success">4.6% increase since last month</p>
            </div>
          </div>
    </div>
    <div class="col-12 col-md-6 mb-4 mb-lg-0 col-lg-3">
        <div class="card">
            <h5 class="card-header">Purchases</h5>
            <div class="card-body">
              <h5 class="card-title">43</h5>
              <p class="card-text">Feb 1 - Apr 1, United States</p>
              <p class="card-text text-danger">2.6% decrease since last month</p>
            </div>
          </div>
    </div>

    <!--ONE LITTLE MODAL----->
    <div class="col-12 col-md-6 mb-4 mb-lg-0 col-lg-3">
        <div class="card">
            <h5 class="card-header">Traffic</h5>
            <div class="card-body">
              <h5 class="card-title">64k</h5>
              <p class="card-text">Feb 1 - Apr 1, United States</p>
              <p class="card-text text-success">2.5% increase since last month</p>
            </div>
        </div>
    </div>

</div>

<!-- DEFINES ELEMENTS ON SAME HORIZONTAL LEVEL --->
<div class="row">
    <div class="col-12 col-xl-8 mb-4 mb-lg-0">
        <div class="card">
            <h5 class="card-header">Your current faculty list</h5>
            <div class="card-body">
            <iframe style="background: #21313C;border: none;border-radius: 2px;box-shadow: 0 2px 10px 0 rgba(70, 76, 79, .2);" width="640" height="480" src="https://charts.mongodb.com/charts-project-nbp-vmmqp/embed/charts?id=caa20678-1c79-4188-97ad-ec223964cf49&theme=dark"></iframe>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-4">
        <div class="card">
            <h5 class="card-header">Traffic last 6 months</h5>
            <div class="card-body">
                <div id="traffic-chart"></div>
            </div>
        </div>
    </div>
</div>

      


<?php include __DIR__ . '/../_footer.php'; ?>