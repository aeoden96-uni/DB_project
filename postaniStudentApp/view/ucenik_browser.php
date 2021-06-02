
<?php include __DIR__ . '/_header.php'; ?>


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?rt=ucenik">Dashboard</a></li>
        <li class="breadcrumb-item active">Browser</li>
    </ol>
</nav>
<h1 class="h2">Faculty browser</h1>
<p>This is the homepage of a simple admin interface which is part of a tutorial written on Themesberg</p>




<?php

$data_array = iterator_to_array($result);
echo("<br>");
echo("<br>");
print_r($data_array[0]);

/*foreach ($result as $r){
    $id=$r->_id;
    print_r((string)$id);
    echo("<br>");
    print_r($r->name);
    echo("<br>");
    print_r($r->age);
}**/



include __DIR__ . '/_footer.php'; ?>