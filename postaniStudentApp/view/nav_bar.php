<nav class="navbar navbar-light bg-light p-3">
        <div class="d-flex col-12 col-md-3 col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
            <a class="navbar-brand" href="#">
                Dashboard
            </a>
            <button class="navbar-toggler d-md-none collapsed mb-3" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <!--<div class="col-12 col-md-4 col-lg-2">
            <input class="form-control form-control-dark" type="text" placeholder="Search" aria-label="Search">
        </div>-->
        <div class="col-12 col-md-4 col-lg-2">
            <nav aria-label="breadcrumb">
                <ol style="margin-bottom:0;" class="breadcrumb">
                    <li class="breadcrumb-item active"> <?php echo $this->USERTYPE." ". $ucenikName; ?></li>
                </ol>
            </nav>
        </div>
        <div class="col-12 col-md-5 col-lg-8 d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
            
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                  Hello, <?php echo $ucenikName; ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <li><a class="dropdown-item" href="#">User Settings</a></li>
                  <li><a class="dropdown-item" href="#">Notifications</a></li>
                  <li><a class="dropdown-item" href="index.php?rt=start/logout">Sign out</a></li>
                </ul>
              </div>
        </div>
    </nav>