<?php
include 'partials/header.php';

$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
unset($_SESSION['signup-data']);
?>

<section class="signup__form">
  <h2>Sign up</h2>
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
  <?php elseif(isset($_SESSION['signup'])) :?>
    <p><?= $_SESSION['signup'];
    unset($_SESSION['signup']); ?></p>
  <?php endif ?>
  <form action="<?= ROOT_URL ?>signup-logic.php" enctype="multipart/form-data" method="POST">
    <div class="txt_field">
      <input type="text" name="firstname" value="<?= $firstname ?>" required>
      <span></span>
      <label>First Name</label>
    </div>
    <div class="txt_field">
      <input type="text" name="lastname" value="<?= $lastname ?>" required>
      <span></span>
      <label>Last Name</label>
    </div>
    <div class="txt_field">
      <input type="text" name="username" value="<?= $username ?>" required>
      <span></span>
      <label>Userame</label>
    </div>
    <div class="txt_field">
      <input type="email" name="email" value="<?= $email ?>" autocomplete="off" required>
      <span></span>
      <label>Email</label>
    </div>
    <div class="txt_field">
      <input type="password" name="createpassword" value="<?= $password ?>" autocomplete="off" required>
      <span></span>
      <label>Password</label>
    </div>
    <div class="txt_field">
      <input type="password" name="confirmpassword" autocomplete="off" required>
      <span></span>
      <label>Confirm Password</label>
    </div>
    <div class="form__control">
        <label for="avatar">Your Avatar</label>
        <input type="file" name="avatar" id="avatar">
    </div>
    <input type="submit" value="Register" name="submit">
    <div class="signup_link">
      Not a member yet? <a href="<?= ROOT_URL ?>signup.php">Sign up</a> now!!!
    </div>
  </form>
</section>

<?php
include 'partials/footer.php';
?>