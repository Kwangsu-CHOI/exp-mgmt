<?php
include 'config/database.php';
phpinfo();
$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="icon" type="image/png" href="<?= ROOT_URL ?>/images/icon.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.1.2/css/fontawesome.min.css" integrity="sha384-X8QTME3FCg1DLb58++lPvsjbQoCT9bp3MsUU3grbIny/3ZwUJkRNO8NPW6zqzuW9" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="<?= ROOT_URL ?>css/style.css?v=<?php echo time(); ?>">
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/nano.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
<section class="signin__form">
  <div class="left">
    <div class="image__container">
      <img src="<?= ROOT_URL ?>/images/sign-in.jpg" alt="">
    </div>
  </div>
  <div class="right">
    <h2>Sign In</h2>
    <?php if(isset($_SESSION['signup-success'])): ?>
      <div class="alert__message success">
        <p>
          <?= $_SESSION['signup-success'];
          unset($_SESSION['signup-success']);
          ?>
        </p>
      </div>
    <?php elseif(isset($_SESSION['signin'])) : ?>
      <div class="alert__message error">
        <p>
          <?= $_SESSION['signin'];
          unset($_SESSION['signin']);
          ?>
        </p>
      </div>
    <?php endif ?>
    <form action="<?= ROOT_URL ?>signin-logic.php" method="POST">
      <div class="txt_field">
        <input type="text" name="username_email" value="<?= $username_email ?>" required>
        <span></span>
        <label>Username or Email</label>
      </div>
      <div class="txt_field">
        <input type="password" name="password" value="<?= $password ?>" required>
        <span></span>
        <label>Password</label>
      </div>
      <input type="submit" value="Login" name="submit">
      <div class="signup_link">
        Not a member yet? <a href="<?= ROOT_URL ?>signup-page.php">Sign up</a> now!!!
      </div>
    </form>
  </div>
</section>

<?php
include 'partials/footer.php';
?>