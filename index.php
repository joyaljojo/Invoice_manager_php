<?php 
session_start();
require "data.php";
if(isset($_POST['DNumber'])){
    $del=$_POST['DNumber'];
    $sql = 'DELETE FROM invoices WHERE number = :number';
    $stmt = $db->prepare($sql);
    // Bind the parameter values
    $stmt->bindParam(':number', $del);
    $stmt->execute();
}

if (isset($_GET['status'])) {
    $status = $_GET['status'];

    // Prepare the SQL query based on the selected status
    if ($status === 'paid') {
        $sql = "SELECT invoices.id,invoices.number, invoices.email, invoices.client, invoices.amount, statuses.status
                FROM invoices
                INNER JOIN statuses ON invoices.status_id = statuses.id
                WHERE statuses.status = 'paid'";
    } elseif ($status === 'pending') {
        $sql = "SELECT invoices.id,invoices.number, invoices.email, invoices.client,invoices.amount, statuses.status
                FROM invoices
                INNER JOIN statuses ON invoices.status_id = statuses.id
                WHERE statuses.status = 'pending'";
    } elseif ($status === 'draft') {
        $sql = "SELECT invoices.id,invoices.number, invoices.email,invoices.client, invoices.amount, statuses.status
                FROM invoices
                INNER JOIN statuses ON invoices.status_id = statuses.id
                WHERE statuses.status = 'draft'";
    } else {
        // If 'all' or an invalid status is selected, retrieve all invoices
        $sql = "SELECT invoices.id,invoices.number, invoices.email,invoices.client, invoices.amount, statuses.status
                FROM invoices
                INNER JOIN statuses ON invoices.status_id = statuses.=id";
    }
} else {
    // If no specific status is selected, retrieve all invoices
    $sql = "SELECT invoices.id,invoices.number, invoices.email, invoices.amount,invoices.client, statuses.status
            FROM invoices
            INNER JOIN statuses ON invoices.status_id = statuses.id";
}

$result = $db->query($sql);
if ($result->rowCount() > 0) {
    $row=$result->rowCount();
    $filteredInvoices = $result->fetchAll(PDO::FETCH_ASSOC);}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="style.css" rel="stylesheet">
<title>Invoice Manger</title>
</head>
<body><div class="container pt-3"> 
<h1>Invoice Manger</h1>
<p>There are <?php echo $row?> Invoices</p>
<div class="container pt-1">
<nav class="navbar navbar-expand-sm navbar-light bg-lightht">
<div class="container-fluid">
<ul class="navbar-nav me-auto mb-2 mb-lg-0-0">
    <li class="nav-item">
    <a class="nav-link" href="index.php"> All</a>
    </li>
    <li class="nav-item">
    <a class="nav-link"href="index.php?status=draft">Draft</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="index.php?status=pending">Pending</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="index.php?status=paid">Paid</a>
    </li>
</ul>
</div>
<a class="btn btn-outline-primary " href="add.php">Add</a>
</nav>


<table class="table table-bordered">
    <thead class="text-bg-dark">
        <th >Number</th>
        <th >Client</th>
        <th >Amount</th>
        <th >Status</th>
        <th>Modify</th>
        <th>view</th>
        
</thead>  

<?php 
echo "<tbody>";
echo "<tr>";

foreach ($filteredInvoices as $client){
        
   
    
            echo "<td class='h6'>#{$client['number']}</p>";
            echo "<td class='h5 text-primary'> {$client['client']}</td>";
            echo "<td > $.{$client['amount']}</td>";
            if($client['status']=='paid'):
                echo "<td><p class=' fs-5 container w-3 p-2 badge bg-success'>{$client['status']}</p></td>";
                echo "<td><a  class='mar btn btn-outline-secondary' href='update.php?id={$client['number']}'>Update</a><a  class='btn btn-outline-danger' href='delete.php?id={$client['number']}'>Delete</a></td>";
                endif;
            if($client['status']=='pending'):
                echo "<td><p class=' fs-5 container w-3 p-2 badge bg-warning'>{$client['status']}</p></td>";
                echo "<td><a  class='mar btn btn-outline-secondary' href='update.php?id={$client['number']}'>Update</a><a  class='btn btn-outline-danger' href='delete.php?id={$client['number']}'>Delete</a></td>";
                endif;
            if($client['status']=='draft'):
                echo "<td><p class=' fs-5 container w-3 p-2 badge bg-secondary'>{$client['status']}</p></td>";
                echo "<td><a  class='mar btn btn-outline-secondary' href='update.php?id={$client['number']}'>Update</a><a  class='btn btn-outline-danger' href='delete.php?id={$client['number']}'>Delete</a></td>";
                    endif;
            if (file_exists("documents/{$client['number']}.pdf")) {
                        echo "<td><a  class='mar btn btn-outline-secondary' class='edit' href='documents/{$client['number']}.pdf' target='_blank'>View</a></td>";
                      }
                      else{
                        echo "<td class='text-danger'>Not available</td>";
                      }
        
            echo"</tr>";  
    }
     echo "</tbody>";
        echo "</table>";?>
</body>
</html>