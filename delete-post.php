<?php
require 'config/database.php';

if(isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

  $query = "SELECT * FROM transactions WHERE id=$id";
  $result = mysqli_query($connection, $query);

  if(mysqli_num_rows($result) == 1) {
    $delete_query = "DELETE FROM transactions WHERE id=$id LIMIT 1";
    $delete_result = mysqli_query($connection, $delete_query);
    $index_query = "ALTER TABLE transactions AUTO_INCREMENT=1";
    $index_result = mysqli_query($connection, $index_query);
    
    if(!mysqli_errno($connection)) {
      $_SESSION['delete-transaction-success'] = "Transaction Deleted Successfully!!";
    }    
  }
}

header('location: ' . ROOT_URL . 'transaction-search.php?page=1');
exit();