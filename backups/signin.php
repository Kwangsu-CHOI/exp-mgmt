<?php
include 'partials/header.php';

$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);
?>

<section class="signin__form">
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
      Not a member yet? <a href="<?= ROOT_URL ?>signup.php">Sign up</a> now!!!
    </div>
  </form>
</section>

<?php
include 'partials/footer.php';
?>