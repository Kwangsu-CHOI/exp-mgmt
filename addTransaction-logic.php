<?php
require 'config/database.php';

if(isset($_POST['submit'])) {
  $user_id = $_SESSION['user-id'];
  $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $location = filter_var($_POST['location'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_INT);
  $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
  $date = date('Y-m-d H:i:s', strtotime($_POST['date']));

  // if(!$title) {
  //   $_SESSION['add-post'] = "Please Enter Title";
  // } elseif(!$location) {
  //   $_SESSION['add-post'] = "Please Enter location";
  // } elseif(!$amount) {
  //   $_SESSION['add-post'] = "Please Enter the amount";
  // } elseif(!$image) {
  //   $_SESSION['add-post'] = "Please Enter details";
  // } else {
  //   $_SESSION['add-post'] = "Please Enter";
  // }

  
    $query = "INSERT INTO transactions SET title = '$title', location = '$location', amount = $amount, description = '$description', date_time = '$date', category_id = $category_id, user_id = $user_id";
    // $query = "INSERT INTO posts SET title = '$title', body = '$body', thumbnail = '$thumbnail_name', category_id = $category_id, author_id = $author_id, is_featured = $is_featured";
    $result = mysqli_query($connection, $query);
    if(!mysqli_errno($connection)) {
      $_SESSION['add-category-success'] = "New Post Added Successfully";
      header('location: ' . ROOT_URL . 'transaction-search.php?page=1');
      exit();
    }

} else {
  header('location: ' . ROOT_URL . 'transaction-search.php?page=1');
  exit();
}