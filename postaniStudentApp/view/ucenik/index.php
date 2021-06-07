
<?php include __DIR__ . '/../_header.php'; ?>



<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
</nav>
<h1 class="h2">Dashboard</h1>
<p>This is your student dashboard.</p>

<!--HORIZ CONTAINER
my-4 = MARGIN top bottom
-->
<div class="row my-4">

    <!--ONE LITTLE MODAL----->
    <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
        <div class="card">
            <h5 class="card-header">Lock status <span class="text-<?php echo $lockBool? "warning" : "success"; ?>"><?php echo $lockBool? "LOCKED" : "UNLOCKED"; ?></span></h5>
            <div class="card-body">
              <h5 class="card-title">Planned lock date: <?php echo $lockDateString;?></h5>
              <p class="card-text">Here you can see how much time you have until your faculty list is locked.</p>
              
            </div>
          </div>
    </div>
    <div class="col-12 col-md-6 mb-4 mb-lg-0 col-lg-3">
        <div class="card">
            <h5 class="card-header">Results status <span class="text-<?php echo $resultBool? "success" : "warning"; ?>"><?php echo $resultBool? "SHOWN" : "NOT SHOWN"; ?></span></h5>
            <div class="card-body">
              <h5 class="card-title">Planned results date: <?php echo $resultDateString;?></h5>
              <p class="card-text">Here you can when will when will results be shown.</p>
              
            </div>
          </div>
    </div>


    <!--ONE LITTLE MODAL----->
    <div class="col-12 col-md-6 mb-4 mb-lg-0 col-lg-3">
        <div class="card">
            <h5 class="card-header">Issues?</h5>
            <div class="card-body">
              <h5 class="card-title">Send mail</h5>
              <p class="card-text">Send mail to ***@gmail.com</p>
              
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
                    <th scope="col">Prefference</th>
                    <th scope="col">Faculty name</th>
                    <th scope="col">OIB</th>
                    <th scope="col">Quota</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $redBr=0;
                    if ($new_list != null)
                        foreach($new_list as $faks){
                            
                            $faks=$faks[0];
                            
                            echo 
                            '<tr>'.
                                '<th scope="row">'.($redBr+1) .'</th>'. 
                                '<td>'.$faks->naziv .'</td>'. 
                                '<td>'.$faks->oib .'</td>'.
                                '<td>'.$faks->kvota .'</td>'.
                               
                            '</tr>';
                            $redBr+=1;
                        }
                    ?>
                   
                </tbody>
                </table>
                </div>
                <a href="index.php?rt=ucenik/myList" class="btn btn-block btn-light">View all</a>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-4">
        <div class="card">
            <h5 class="card-header">Faculty chart</h5>
            <div class="card-body">
            <iframe style="background: #FFFFFF;border: none;border-radius: 2px;box-shadow: 0 2px 10px 0 rgba(70, 76, 79, .2);" width="100%" height="300px"  src="https://charts.mongodb.com/charts-project-nbp-vmmqp/embed/charts?id=93ce6b26-32f3-4096-94b1-a4f6e9b94afe&theme=light"></iframe>
            </div>
        </div>
    </div>
</div>





      


<?php include __DIR__ . '/../_footer.php'; ?>