<?php

require 'config/database.php';

//get signup form

if(isset($_POST['submit'])) {
  $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
  $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $avatar = $_FILES['avatar'];

  //validation
  if(!$firstname) {
    $_SESSION['signup'] = "Please Enter Your First Name";
  } elseif(!$lastname) {
    $_SESSION['signup'] = "Please Enter Your Last Name";
  } elseif(!$username) {
    $_SESSION['signup'] = "Please Enter Your Username";
  } elseif(!$email) {
    $_SESSION['signup'] = "Please Enter Valid Email";
  } elseif(strlen($createpassword) < 6 || strlen($confirmpassword) < 6) {
    $_SESSION['signup'] = "Your Password Must Be At Least 6 Charaters Long";
  } elseif(!$avatar['name']) {
    $_SESSION['signup'] = "Please Add Your Avatar";
  } else {
    if($createpassword !== $confirmpassword) {
      $_SESSION['signup'] = "Passwords Don't Match";
    } else {
      $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);
      
      //existance of input: email
      $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
      $user_check_result = mysqli_query($connection, $user_check_query);
      if(mysqli_num_rows($user_check_result) > 0) {
        $_SESSION['signup'] = "Your Username or Email has already been taken";
      } else {
        //avatar rename
        $time = time();
        $avatar_name = $time . $avatar['name'];
        $avatar_tmp_name = $avatar['tmp_name'];
        $avatar_destination_path = 'images/' . $avatar_name;

        //avatar file type
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extention = explode('.', $avatar_name);
        $extention = end($extention);
        if(in_array($extention, $allowed_files)) {
          if($avatar['size'] < 1000000) {
            //avatar upload
            move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
          } else {
            $_SESSION['signup'] = 'File Size Must Not Exceed 1 Mb';
          }
        } else {
          $_SESSION['signup'] = 'File Type Should be either .png, .jpg, or .jpeg';
        }
      }
    }
  }

  if(isset($_SESSION['signup'])) {
    $_SESSION['signup-data'] = $_POST;
    header('location: ' . ROOT_URL . 'signup-page.php');
    exit();
  } else {
    //to the database
    $status = 'Online';
    $random_id = rand(time(), 10000000);

    $insert_user_query = "INSERT INTO users SET unique_id=$random_id, firstname='$firstname', lastname='$lastname', username='$username', email='$email', password='$hashed_password', avatar='$avatar_name', status='$status', is_admin=0";
    $inser_user_result  = mysqli_query($connection, $insert_user_query);

    if(!mysqli_errno($connection)) {
      $_SESSION['signup-success'] = "Registration Done. Please Log In Now!!";
      header('location: ' . ROOT_URL . 'signin-page.php');
      exit();
    }
  }
} else {
  header('location: ' . ROOT_URL . 'signup-page.php');
  exit();
}