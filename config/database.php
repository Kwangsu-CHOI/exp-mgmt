<?php
require 'constants.php';

//database connection

$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


if(mysqli_errno($connection)) {
  die(mysqli_error($connection));
};

// try {
//   $conn = new pdo("mysql:host=DB_HOST;dbname=DB_NAME", DB_USER, DB_PASS);
// } catch(PDOException $e) {
//   die($e->getMessage());
// }


