
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
                   
                    <?php if(!$lockBool) echo '<th scope="col"></th>'; ?>
                    
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ind=0;
                    foreach($list as $faks){
                        $c=checkList($faks->oib,$listaFaksevaUcenika);
                        echo 
                        '<tr data-toggle="collapse" data-target="#accordion'.$ind .'" class="clickable collapse-row collapsed">'.
                            '<th scope="row">'.$faks->oib .'</th>'. 
                           
                            '<td>'.$faks->naziv .'</td>'.
                            '<td>'.$faks->kvota .'</td>';
                           
                        if(!$lockBool) echo '<td><a href="index.php?rt=ucenik/myListInsert/'.$faks->oib.'" class="btn btn-sm btn-'. ($c?"secondary":"success") .'">'. ($c?"Added":"Add") .'</a></td>';
                           

                        echo '</tr>';

                        echo 
                        '<tr>
                            <td colspan="3">
                                <div class="row my-4" id="accordion'.$ind.'" class="collapse">
                                    <div class="col-12 col-md-6 mb-4 mb-lg-0 col-lg-3">
                                        <div class="card">
                                            <h5 class="card-header">Requirements</h5>
                                            <div class="card-body">
                                            
                                            <p class="card-text">mathematics '.$faks->uvjeti->matematika.'x</p>
                                            <p class="card-text">Croatian '.$faks->uvjeti->hrvatski.'x</p>
                                            <p class="card-text">English '.$faks->uvjeti->engleski.'x</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-4 mb-lg-0 col-lg-3">
                                        <div class="card">
                                            <h5 class="card-header">You also get points for</h5>
                                            <div class="card-body">
                                                <p class="card-text">'.$faks->uvjeti->izborni.'</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-4 mb-lg-0 col-lg-3">
                                        <div class="card">
                                            <h5 class="card-header">Quota</h5>
                                            <div class="card-body">
                                            <h5 class="card-title">'.$faks->kvota.' students </h5>
                                            
                                            </div>
                                        </div>
                                    </div>';
                            if(!$lockBool)echo 
                                    '<div class="col-12 col-md-6 mb-4 mb-lg-0 col-lg-3">
                                        <div class="card">
                                            <h5 class="card-header">Add to your list</h5>
                                            <div class="card-body">
                                                <p class="card-text">Click to add this faculty.</p>

                                                <a href="index.php?rt=ucenik/myListInsert/'.$faks->oib.'" class="btn btn-sm btn-'. ($c?"secondary":"success") .'">'. ($c?"Added":"Confirm add") .'</a>
                                           
                                            </div>
                                        </div>
                                    </div>';
                            echo    '</div>
                            </td>
                        </tr>';
                        $ind+=1;
                    }
                    ?>
                   
                </tbody>
                </table>
        </div>
        
    </div>
</div>



<style>
.collapse-row.collapsed + tr {
  display: none;
}
</style>

<?php

/*$data_array = iterator_to_array($result);
echo("<br>");
echo("<br>");
print_r($data_array[0]);*/




include __DIR__ . '/../_footer.php'; ?>