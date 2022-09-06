<?php
require 'config/database.php';


if (!empty($_POST['search'])) {
  header('location: ' . ROOT_URL . 'transaction-search.php?search=' . $_POST['search'] . '&page=1');
  exit();
} else {
  header('location: ' . ROOT_URL . 'transaction-search.php?page=1');
  exit();
}