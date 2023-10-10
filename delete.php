<?php 
require_once("data.php");
 
if(isset($_GET['id'])){
    $sql = "SELECT invoices.id,invoices.number, invoices.email, invoices.client, invoices.amount, statuses.status
                    FROM invoices
                    INNER JOIN statuses ON invoices.status_id = statuses.id
                    WHERE invoices.number =:number";
     $stmt = $db->prepare($sql);
     $stmt->execute(array(':number' => $_GET['id']));
    
        $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Delete</title>
</head>
<body>
<div class="container pt-5"> 
    <h1>Invoice Manger</h1>
    <div  class="d-flex justify-content-between">
    <div><p class=" h5 text-muted">Delete Invoice</p></div>
    <div ><a class="btn btn-primary" href="index.php" >Back</a></span></div></div><br>
    <form  method="post"  action="index.php">
        <?php foreach ($invoices as $details): ?>
        <div class="alert alert-danger">
            <input type="text" class="form-control" value="<?php echo $details['number']; ?>" name="DNumber" id="DNumber" required>
            
            <label for="Client Name" class="form-label">Client Name</label>
            <input type="text" class="form-control" value="<?php echo $details['client']; ?>" name="DName" id="DName" required> 
       
        <div  class="mb-3">
            <label for="Client Email" class="form-label">Client Email</label>
            <input type="email" class="form-control" value="<?php echo $details['email']; ?>" name="DEmail" id="DEmail" required>
        </div>
        <div  class="mb-3"> 
        <label for="Invoice Amount" class="form-label">Invoice Amount</label>
            <input type="text"  class="form-control" value="<?php echo $details['amount']; ?>" name="DAmount" id="DAmount" required> 
        </div>   
        <div  class="mb-3">
        <label for="Invoice Status" class="form-label">Invoice Status</label>
            <select id="Dstatus" name="DStatus" class="form-select"  >
                <option value="<?php echo $details['status']?>" placeholder="" selected><?php echo $details['status']; ?></option>
                <option value="" selected>Select a Value</option>
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
                <option value="draft">Draft</option>
                
                </select>
                <?php endforeach; ?>
            
        </div>    
        <div>
            <button class="btn btn-outline-dark" id="submit" type="submit" value="submit">Submit</button>
        </div>
        </div>
    </form>