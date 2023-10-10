<?php
require "data.php";
function sanitize($data) {
    return array_map(function ($value) {
      return htmlspecialchars(stripslashes(trim($value)));
    }, $data);
}
function savePdf($invoiceNumber){
  $pdf = $_FILES['invoicepdf'];

  if ($pdf['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($pdf['name'], PATHINFO_EXTENSION);
    $filename = $invoiceNumber . '.' . $ext;

    if (!file_exists('documents/')) {
      mkdir('documents/');
    }

    $dest = 'documents/' . $filename;

    if (file_exists($dest)) {
      unlink($dest);
    }

    return move_uploaded_file($pdf['tmp_name'], $dest);
  }

  return false;
}

function addInvoice ($in) {

  global $db;
  global $statuses;
  $random_number = getInvoiceNumber();
  $status_id = array_search($in['status'], $statuses) + 1;

  $sql = "INSERT INTO invoices (number, client, email, amount, status_id)
  VALUES (:number,:client, :email, :amount, :status_id)";
  $result = $db->prepare($sql);
  
  $result->execute([
    ':number' => $random_number,
    ':client' => $in['client'], 
    ':email' => $in['email'],
    ':amount' => $in['amount'], 
    ':status_id' => $status_id
  ]);
  
  $invoiceId = $db->lastInsertId();
  savePdf($random_number);

  return $invoiceId;

  }

  function getInvoiceNumber ($length = 5) {
    $letters = range('A', 'Z');
    $number = [];
    
    for ($i = 0; $i < $length; $i++) {
      array_push($number, $letters[rand(0, count($letters) - 1)]);
    }
    return implode($number);
}

function validate($invoice) {
  require "data.php";
  $fields = ['amount', 'client', 'email', 'status'];
  $errors = [];

  foreach ($fields as $field) {
    switch ($field) {
      case 'amount':
        if (empty($invoice[$field])) {
            $errors[$field] = 'Amount is required';
        } elseif (!is_numeric($invoice[$field])) {
            $errors[$field] = 'Amount must be a number';
        }
        break;
      case 'client':
        if (empty($invoice[$field])) {
          $errors[$field] = 'Client is required';
        } else if (!preg_match('/^[a-zA-Z\s]+$/', $invoice[$field])) {
          $errors[$field] = ' Client must contain only letters and spaces';
        } else if (strlen($invoice[$field]) > 255) {
          $errors[$field] = 'Client must be fewer than 255 characters';
        }
        break;
      case 'email':
        if (empty($invoice[$field])) {
          $errors[$field] = 'Email is required';
        } else if (filter_var($invoice[$field], FILTER_VALIDATE_EMAIL) === false) {
          $errors[$field] = 'Email must be in format';
        }
        break;
      case 'status':
        if (empty($invoice[$field])) {
          $errors[$field] = 'Status is required';
        } else if (!in_array($invoice[$field], $statuses)) {
          $errors[$field] = 'Status must be in the list of genres';
        }
        break;
    }
  }
  return $errors;
}

function updateInvoice($in) {

  global $db;
  global $statuses;

    $status_id = array_search($in['status'], $statuses) + 1;

    $sql = "UPDATE invoices SET client = :client, email = :email, amount = :amount, status_id = :status_id WHERE number = :number";
    $stmt = $db->prepare($sql);
    $stmt->execute([
      'number' => $in['number'],
      'client' => $in['client'],
      'email' => $in['email'],
      'amount' => $in['amount'],
      'status_id' => $status_id
    ]);
    savePdf($in['number']);
    return $in['number'];

}

function getInvoice ($number) {
  global $db;

  $sql = "SELECT * FROM invoices JOIN statuses ON invoices.status_id = statuses.id WHERE number = :number";
  $result = $db->prepare($sql);
  $result->execute([':number' => $number]);
  $inv = $result->fetch();
  return $inv;

}
?>