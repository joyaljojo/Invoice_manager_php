<?php 

$dsn = 'mysql:host=localhost;dbname=invoice_manager';
$username = 'root';
$password = 'joseph*123';

try {
  $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
  $error = $e->getMessage();
  echo $error;
  exit();
}

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$sql = "SELECT * FROM statuses";
$result = $db->query($sql);
$statuses = $result->fetchAll(PDO::FETCH_COLUMN, 1);

$sql = "SELECT * FROM invoices";
$result = $db->query($sql);
$invoices = $result->fetchAll();


?>