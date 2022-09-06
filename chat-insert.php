<?php
  require './config/database.php';

  if(isset($_SESSION['unique_id'])) {
    $outgoing_id = mysqli_real_escape_string($connection, $_POST['outgoing_id']);
    $incoming_id = mysqli_real_escape_string($connection, $_POST['incoming_id']);
    $message = mysqli_real_escape_string($connection, $_POST['message']);
  }

  if(!empty($message)) {
    $insert_msg_query = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg) VALUES ({$incoming_id}, {$outgoing_id}, '{$message}')";
    $insert_msg_result = mysqli_query($connection, $insert_msg_query) or die();
  }
?>