<?php
session_start();
require "data.php";
require "function.php";


$invoiceNumber = $_GET['id'];

$foundInvoice = null;
foreach ($invoices as $invoice) {
  if ($invoice['number'] === $invoiceNumber) {
    $foundInvoice = $invoice;
    break;
  }
}
$invoice = getInvoice($invoice['number']);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $invoice = sanitize($_POST);
  $error = validate($invoice);
  
  if (count($error) === 0) {
    updateInvoice($invoice);
    header("Location: index.php");
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  

</head>

<body>

  <div class="container pt-5"> 
    <h1>Invoice Manger</h1>
    <div  class="d-flex justify-content-between">
    <div><p class=" h5 text-muted">Update Invoice</p></div>
    <div ><a class="btn btn-primary" href="index.php" >Back</a></span></div></div><br>
    <form class="form" method="post" enctype="multipart/form-data">
    <div class=" alert alert-secondary">
        <input type="hidden" name="add-invoice" value="1">
        <div class="form-group">
          <label for="amount">Amount</label>
          <input type="text" class="form-control" name="amount" id="amount" placeholder="" value="<?php echo  $_POST['amount'] ?? $foundInvoice['amount']; ?>">
          <?php if (isset($error['amount'])) : ?>
            <p class="text-danger"><?php echo $error['amount']; ?></p>
          <?php endif; ?>
        

        <div  class="mb-3">
          <label for="client">Client</label>
          <input type="text" class="form-control" id="client" name="client" placeholder="" value="<?php echo  $_POST['client'] ?? $foundInvoice['client']; ?>">
          <?php if (isset($error['client'])) : ?>
            <p class="text-danger"><?php echo $error['client']; ?></p>
          <?php endif; ?>
        </div>
      </div>

      <div  class="mb-3">
        <label for="email">Email</label>
        <input type="text" class="form-control" id="email" name="email" placeholder="" value="<?php echo  $_POST['email'] ?? $foundInvoice['email']; ?>">
        <?php if (isset($error['email'])) : ?>
          <p class="text-danger"><?php echo $error['email']; ?></p>
        <?php endif; ?>
      </div>

      <div  class="mb-3">
        <label for="status">Status</label>
        <select id="status" name="status" class="form-control">
          <option value="">Select a Status</option>
          <?php
          require "data.php";
          
          foreach ($statuses as $status) :
          ?>

            <option value="<?php echo $status; ?>" <?php if (isset($invoice['status']) && $status === $invoice['status']) : ?> selected <?php endif; ?>>
              <?php echo $status; ?>
            </option>
          <?php endforeach; ?>
        </select>
        <?php if (isset($error['status'])) : ?>
          <p class="text-danger"><?php echo $error['status']; ?></p>
        <?php endif; ?>
      </div>

      <div>
        <input type="hidden" name="number" value="<?php echo $foundInvoice['number']; ?>">
      </div>
        </br>
       <div>
          <input
                  type="file"
                  class="form-control"
                  name="invoicepdf"
                  accept=".pdf">
       </div>

      <button type="submit" class="btn btn-primary">Update Invoice</button>
    </form>
  </div>


</body>

</html>
<?php
//var_dump($inv['status']);
?>