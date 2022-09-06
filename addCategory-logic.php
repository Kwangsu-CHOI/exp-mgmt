<?php
require 'config/database.php';

if(isset($_POST['submit'])) {
  $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  if(!$title) {
    $_SESSION['add-category'] = "Please Enter Title";
  } elseif (!$description) {
    $_SESSION['add-category'] = "Please Enter Description";
  }

  if(isset($_SESSION['add-category'])) {
    $_SESSION['add-category-data'] = $_POST;
    header('location: ' . ROOT_URL . 'transaction-search.php');
    exit();
  } else {
    $query = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";
    $result = mysqli_query($connection, $query);
    if(mysqli_errno($connection)) {
      $_SESSION['add-category'] = "Couldn't Add Category";
      header('location: ' . ROOT_URL . '/');
      exit();
    } else {
      $_SESSION['add-category-success'] = "'$title' Is Added";
      header('location: ' . ROOT_URL . 'transaction-search.php?page=1');
      exit();
    }
  }
}