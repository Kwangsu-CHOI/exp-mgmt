<?php
  include_once 'config/database.php';

  $searchTerm = mysqli_real_escape_string($connection, $_POST['searchTerm']);
  
  $search_query = "SELECT * FROM users WHERE firstname LIKE '%{$searchTerm}%' OR lastname LIKE '%{$searchTerm}%'";
  $search_result = mysqli_query($connection, $search_query);

  if(mysqli_num_rows($search_result)>0) {
    include './chat-search.php';
  } else {
    echo "&#34;" . $_POST['searchTerm'] . "&#34;" . " " . 'is not found';
  }

?>
