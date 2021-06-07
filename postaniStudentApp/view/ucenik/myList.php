
<?php include __DIR__ . '/../_header.php'; 


function addButtons($id){
    
    return '<div class="btn-group mr-2" role="group" aria-label="Second group">'.
            '<a type="button" href="index.php?rt=ucenik/myListPushUp/' . $id . '" class="btn btn-secondary">▲</a>'.
            '<a type="button" href="index.php?rt=ucenik/myListPushDown/' . $id . '" class="btn btn-secondary">▼</a>'.
        '</div>';

}

function addFirstButtons($id){
    if($id==0)
        return '<div class="btn-group mr-2" role="group" aria-label="Second group">'.
                '<a type="button" href="index.php?rt=ucenik/myListPushDown/' . $id . '" class="btn btn-secondary">▼</a>'.
            '</div>';
    return '<div class="btn-group mr-2" role="group" aria-label="Second group">'.
    '<a type="button" href="index.php?rt=ucenik/myListPushUp/' . $id . '" class="btn btn-secondary">▲</a>'.
    '</div>';
    

}



?>


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?rt=ucenik">Dashboard</a></li>
        <li class="breadcrumb-item active">My List</li>
    </ol>
</nav>
<h1 class="h2">My current faculty list <span class="text-<?php echo $lockBool? "warning" : "success"; ?>"><?php echo $lockBool? "LOCKED" : "NOT LOCKED"; ?></span></h1>
<p>This is your current list of favourite faculties. It will lock after set date,then you wont be able to change it. </p>




<div class="card">
    <h5 class="card-header">My current faculty list <span class="text-<?php echo $lockBool? "warning" : "success"; ?>"><?php echo $lockBool? "LOCKED" : "NOT LOCKED"; ?></span></h5>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Prefference</th>
                    <th scope="col">Faculty name</th>
                    <th scope="col">OIB</th>
                    <th scope="col">Quota</th>
                    <?php echo $lockBool?
                    "": '<th scope="col"></th>
                    <th scope="col"></th>';
                    ?>
                    
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
                                '<td>'.$faks->kvota .'</td>';

                            if(!$lockBool) echo  '<td>'.(($redBr==0 || $redBr==count($new_list)-1)? addFirstButtons($redBr ):addButtons($redBr )).'</td>'.
                                '<td><a href="index.php?rt=ucenik/myListDelete/'.$redBr .'" class="btn btn-sm btn-warning">Remove</a></td>';
                            echo '</tr>';
                            $redBr+=1;
                        }
                    ?>
                   
                </tbody>
                </table>
        </div>
        
        
    </div>
</div>





<?php include __DIR__ . '/../_footer.php'; ?>