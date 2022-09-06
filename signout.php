<?php
  require 'config/database.php';

  $logout_id = mysqli_real_escape_string($connection, $_GET['logout_id']);
  if(isset($logout_id)) {
    $status = 'Offline';
    $logout_qeury = "UPDATE users SET status = '{$status}' WHERE unique_id = {$logout_id} ";
    $logout_result = mysqli_query($connection, $logout_qeury);
    session_unset();
    session_destroy();
    header('location: ' . ROOT_URL . 'signin-page.php');
    exit();
  }

?>