
<?php include __DIR__ . '/../_header.php'; ?>


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?rt=ucenik">Dashboard</a></li>
        <li class="breadcrumb-item active">Results</li>
    </ol>
</nav>
<h1 class="h2">Results</h1>
<p>This is the result list.</p>




<div class="card">
    <h5 class="card-header">Student list</h5>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">OIB</th>
                   
                    <th scope="col">Last Name</th>
                    <th scope="col">First name</th>
                   
                    
                    
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ind=0;
                    foreach($list as $student){
                        
                        echo 
                        '<tr class=" collapse-row collapsed">'.
                            '<th scope="row">'.$student->username .'</th>'. 
                           
                            '<td>'.$student->prezime  .'</td>'.
                            '<td>'.$student->ime  .'</td>';
                           
                            

                        echo '</tr>';

                        
                        $ind+=1;
                    }
                    ?>
                   
                </tbody>
                </table>
        </div>
        
    </div>
</div>

<div class="card">
    <h5 class="card-header">Enrollment info</h5>
    <div class="card-body">
    <iframe style="background: #FFFFFF;border: none;border-radius: 2px;box-shadow: 0 2px 10px 0 rgba(70, 76, 79, .2);" width="100%" height="480" src="https://charts.mongodb.com/charts-project-nbp-vmmqp/embed/charts?id=07731c13-03bf-48be-ae19-c6d6ca26efc9&theme=light"></iframe>
        
    </div>
</div>



<?php include __DIR__ . '/../_footer.php'; ?>