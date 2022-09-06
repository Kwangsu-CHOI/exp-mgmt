<?php
include 'config/database.php';

if(isset($_POST['id'])) {
  $value = $_POST['value'];
  $column = $_POST['column'];
  $id = $_POST['id'];

  $update_query = "UPDATE transactions SET $column = ? WHERE id = ? LIMIT 1";
  $update_result = mysqli_prepare($connection, $update_query);
  mysqli_stmt_bind_param($update_result, 'ss', $value, $id);
  // mysqli_stmt_bind_param($update_result, 's', $id);

  if($update_result->execute()) {
    echo "Updated Successfully";
  } else {
    echo "Failed to update";
  }
}

?>