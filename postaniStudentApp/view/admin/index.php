
<?php include __DIR__ . '/../_header.php'; ?>



<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
</nav>
<h1 class="h2">Dashboard</h1>
<p>This is the main dashboard for admin. Here you can start or reset aggregation procedure for all students.</p>

<!--HORIZ CONTAINER
my-4 = MARGIN top bottom
-->
<div class="row my-4">

    <!--ONE LITTLE MODAL----->
    <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
        <div class="card">
            <h5 class="card-header">Deadline</h5>
            <div class="card-body">
              <h5 class="card-title">
                *Deadline date*
              </h5>
              <p class="card-text">You can start aggregation only after deadline date defined in global settings.</p>
              
            </div>
          </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
        <div class="card">
            <h5 class="card-header">Start aggregation</h5>
            <div class="card-body">
              <h5 class="card-title">
                <a class="btn btn-sm btn-info ml-3 mt-2" href="index.php?rt=admin/start">
                    ⚡︎ START
                </a>
              </h5>
              <p class="card-text">Start sorting students to faculties.</p>
              
            </div>
          </div>
    </div>
    <div class="col-12 col-md-6 mb-4 mb-lg-0 col-lg-3">
    <div class="card">
            <h5 class="card-header">Reset aggregation</h5>
            <div class="card-body">
              <h5 class="card-title">
                <a class="btn btn-sm btn-danger ml-3 mt-2" href="index.php?rt=admin/reset">
                    ⚡︎ RESET
                </a>
              </h5>
              <p class="card-text">Something went wrong? Undo everything.</p>
              
            </div>
          </div>
    </div>
   

</div>




<?php include __DIR__ . '/../_footer.php'; ?>