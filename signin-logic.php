<?php
require 'config/database.php';

if(isset($_POST['submit'])) {
  $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  if(!$username_email) {
    $_SESSION['signin'] = "Please Enter Username Or Email.";
  } elseif (!$password) {
    $_SESSION['signin'] = "Password Is Incorrect.";
  } else {
    $fetch_user_query = "SELECT * FROM users WHERE username = '$username_email' OR email = '$username_email'";
    $fetch_user_result = mysqli_query($connection, $fetch_user_query);

    if(mysqli_num_rows($fetch_user_result) == 1) {
      //convert into assoc array
      $user_record = mysqli_fetch_assoc($fetch_user_result);
      $db_password = $user_record['password'];
      // compare password input and data
      if(password_verify($password, $db_password)) {
        //set session
        $_SESSION['user-id'] = $user_record['id'];
        $_SESSION['unique_id'] = $user_record['unique_id'];
        $_SESSION['user-login'] = true;
        $login_id = $user_record['unique_id'];
        $status = 'Online';
        if(isset($login_id)) {
          $login_qeury = "UPDATE users SET status = '{$status}' WHERE unique_id = {$login_id}";
          $login_result = mysqli_query($connection, $login_qeury);

        }
        header('location: ' . ROOT_URL . '/');
        exit();
      } else {
        $_SESSION['signin'] = "Please Check Your Login Credentials";
      }
    } else {
      $_SESSION['signin'] = "User Not Found";
    }
  }

  // redirect when problem occurs
  if(isset($_SESSION['signin'])) {
    $_SESSION['signin-data'] = $_POST;
    header('location: ' . ROOT_URL . 'signin-page.php');
    exit();
  }

} else {
  header('location: ' . ROOT_URL . 'signin-page.php');
  exit();
}