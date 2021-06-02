
<?php include __DIR__ . '/../_header.php'; ?>


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
                    <th scope="col">_id</th>
                    <th scope="col">Faculty name</th>
                    <th scope="col">Quota</th>
                    <th scope="col">***</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($list as $faks){
                        echo 
                        '<tr>'.
                            '<th scope="row">'.$faks->oib .'</th>'. 
                            '<td>'.$faks->_id .'</td>'. 
                            '<td>'.$faks->naziv .'</td>'.
                            '<td>'.$faks->kvota .'</td>'.
                            '<td>***</td>'.
                            '<td><a href="#" class="btn btn-sm btn-success">Add</a></td>'.
                            '<td><a href="#" class="btn btn-sm btn-primary">View</a></td>'.

                        '</tr>';
                    }
                    ?>
                   
                </tbody>
                </table>
        </div>
        
    </div>
</div>



















<?php

/*$data_array = iterator_to_array($result);
echo("<br>");
echo("<br>");
print_r($data_array[0]);*/




include __DIR__ . '/../_footer.php'; ?>