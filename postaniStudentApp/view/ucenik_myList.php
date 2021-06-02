
<?php include __DIR__ . '/_header.php'; 


function addButtons($link1,$link2){
    echo '<div class="btn-group mr-2" role="group" aria-label="Second group">
            <a type="button" href="' . $link1 . '" class="btn btn-secondary">▲</a>
            <a type="button" class="btn btn-secondary">▼</a>
        </div>';

}

?>


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?rt=ucenik">Dashboard</a></li>
        <li class="breadcrumb-item active">My List</li>
    </ol>
</nav>
<h1 class="h2">My current faculty list</h1>
<p>This is the homepage of a simple admin interface which is part of a tutorial written on Themesberg</p>




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
        
    </div>
</div>





<?php include __DIR__ . '/_footer.php'; ?>