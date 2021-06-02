
<?php include __DIR__ . '/_header.php'; ?>



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
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">OIB</th>
                            <th scope="col">Prefference</th>
                            <th scope="col">Faculty name</th>
                            <th scope="col">Total score</th>
                            <th scope="col">Requirements met</th>
                            <th scope="col"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row">17371705</th>
                            <td>Volt Premium Bootstrap 5 Dashboard</td>
                            <td>johndoe@gmail.com</td>
                            <td>€61.11</td>
                            <td>Aug 31 2020</td>
                            <td><a href="#" class="btn btn-sm btn-primary">View</a></td>
                          </tr>
                          <tr>
                            <th scope="row">17370540</th>
                            <td>Pixel Pro Premium Bootstrap UI Kit</td>
                            <td>jacob.monroe@company.com</td>
                            <td>$153.11</td>
                            <td>Aug 28 2020</td>
                            <td><a href="#" class="btn btn-sm btn-primary">View</a></td>
                          </tr>
                          <tr>
                            <th scope="row">17371705</th>
                            <td>Volt Premium Bootstrap 5 Dashboard</td>
                            <td>johndoe@gmail.com</td>
                            <td>€61.11</td>
                            <td>Aug 31 2020</td>
                            <td><a href="#" class="btn btn-sm btn-primary">View</a></td>
                          </tr>
                          <tr>
                            <th scope="row">17370540</th>
                            <td>Pixel Pro Premium Bootstrap UI Kit</td>
                            <td>jacob.monroe@company.com</td>
                            <td>$153.11</td>
                            <td>Aug 28 2020</td>
                            <td><a href="#" class="btn btn-sm btn-primary">View</a></td>
                          </tr>
                          <tr>
                            <th scope="row">17371705</th>
                            <td>Volt Premium Bootstrap 5 Dashboard</td>
                            <td>johndoe@gmail.com</td>
                            <td>€61.11</td>
                            <td>Aug 31 2020</td>
                            <td><a href="#" class="btn btn-sm btn-primary">View</a></td>
                          </tr>
                          <tr>
                            <th scope="row">17370540</th>
                            <td>Pixel Pro Premium Bootstrap UI Kit</td>
                            <td>jacob.monroe@company.com</td>
                            <td>$153.11</td>
                            <td>Aug 28 2020</td>
                            <td><a href="#" class="btn btn-sm btn-primary">View</a></td>
                          </tr>
                        </tbody>
                      </table>
                </div>
                <a href="index.php?rt=ucenik/popis" class="btn btn-block btn-light">View all</a>
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
<footer class="pt-5 d-flex justify-content-between">
    <span>Copyright © 2019-2020 <a href="https://themesberg.com">Themesberg</a></span>
    <ul class="nav m-0">
        <li class="nav-item">
          <a class="nav-link text-secondary" aria-current="page" href="#">Privacy Policy</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-secondary" href="#">Terms and conditions</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-secondary" href="#">Contact</a>
        </li>
      </ul>
</footer>
      


<?php include __DIR__ . '/_footer.php'; ?>