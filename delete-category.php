<?php
require 'config/database.php';

if(isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  
  $category_query = "SELECT * FROM categories WHERE id=$id";
  $category_result = mysqli_query($connection, $category_query);
  $category = mysqli_fetch_assoc($category_result);
  
  // posts belonged to delete category now into uncategorised one
  $update_query = "UPDATE transactions SET category_id=99 WHERE category_id=$id";
  $update_result = mysqli_query($connection, $update_query);

  if(!mysqli_errno($connection)) {
    // delete category
    $query = "DELETE FROM categories WHERE id=$id LIMIT 1";
    $result = mysqli_query($connection, $query);
    $_SESSION['delete-category-success'] = "Category '{$category['title']}' Deleted Successfully!";
  }
}
header('location: ' . ROOT_URL . 'transaction-search.php?page=1');
exit();