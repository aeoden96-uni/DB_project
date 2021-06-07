
<?php include __DIR__ . '/../_header.php';

function checkList($oib,$listaFaksevaUcenika){
    

    foreach($listaFaksevaUcenika as $faksOIB){
        if ($faksOIB == $oib){
            
            return true;
        }
            
    }
    return false;

}
?>


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?rt=ucenik">Dashboard</a></li>
        <li class="breadcrumb-item active">Browser</li>
    </ol>
</nav>
<h1 class="h2">Faculty browser</h1>
<p>Here you can seach for a faculty you are interested in,and add it to your list.</p>



<div class="card">
    <h5 class="card-header">Faculty list</h5>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">OIB</th>
                   
                    <th scope="col">Faculty name</th>
                    <th scope="col">Quota</th>
                   
                    
                    
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ind=0;
                    foreach($list as $faks){
                        
                        echo 
                        '<tr class=" collapse-row collapsed">'.
                            '<th scope="row">'.$faks->oib .'</th>'. 
                           
                            '<td>'.$faks->naziv .'</td>'.
                            '<td>'.$faks->kvota .'</td>';
                           
                            

                        echo '</tr>';

                        
                        $ind+=1;
                    }
                    ?>
                   
                </tbody>
                </table>
        </div>
        
    </div>
</div>




<?php



include __DIR__ . '/../_footer.php'; ?>