<?php
include 'partials/header.php';

$unique_id = $_SESSION['unique_id'];
$user_id = $_SESSION['user-id'];

$user_query = "SELECT * FROM users where unique_id = $unique_id";
$user_result = mysqli_query($connection, $user_query);
$user = mysqli_fetch_assoc($user_result);

$all_user_query = "SELECT * FROM users";
$all_user_result = mysqli_query($connection, $all_user_query);

?>

<?php if ($unique_id === $_GET['user_id']) : ?>
  <div class="chat_wrapper">
    <section class="user_list">
      <div class="header">
        <div class="content">
          <img src="<?= ROOT_URL . 'images/' . $user['avatar'] ?>" alt="">
          <div class="user_detail">
            <span><?= $user['firstname'] . ' ' . $user['lastname'] ?></span>
            <p><?= $user['status'] ?></p>
          </div>
        </div>
        <button onClick="window.location.reload()" class="refresh-btn"><i class='bx bx-refresh'></i></button>
      </div>
      <div class="chat_search">
        <span class="text">Select user or Search user</span>
        <input type="text" placeholder="Enter username">
        <button><i class='bx bx-search-alt-2'></i></button>
      </div>
      <div class="user_lists">
        <?php include './chat-search.php' ?>
      </div>
    </section>
  </div>
<?php else : ?>
  <div class="chat_wrapper">
<!-- user list for chat -->
    <section class="user_list">
      <div class="header">
        <div class="content">
          <img src="<?= ROOT_URL . 'images/' . $user['avatar'] ?>" alt="">
          <div class="user_detail">
            <span><?= $user['firstname'] . ' ' . $user['lastname'] ?></span>
            <p><?= $user['status'] ?></p>
          </div>
        </div>
        <button onClick="window.location.reload()" class="refresh-btn"><i class='bx bx-refresh'></i></button>
      </div>
      <div class="chat_search">
        <span class="text">Select user or Search user</span>
        <input type="text" placeholder="Enter username">
        <button><i class='bx bx-search-alt-2'></i></button>
      </div>
      <div class="user_lists">
        <?php include './chat-search.php' ?>
      </div>
    </section>

<!-- chat area -->
    <section class="chat_area">
      <?php
      $userId = mysqli_real_escape_string($connection, $_GET['user_id']);
      $chat_qeury = "SELECT * FROM users WHERE unique_id = $userId";
      $chat_result = mysqli_query($connection, $chat_qeury);
      if (mysqli_num_rows($chat_result) > 0) {
        $chat = mysqli_fetch_assoc($chat_result);
      }
      ?>
      <div class="header">
        <a href="" class="back-icon">
          <i class='bx bxs-arrow-to-left'></i>
        </a>
        <img src="<?= ROOT_URL . 'images/' . $chat['avatar'] ?>" alt="">
        <div class="user_detail">
          <span><?= $chat['firstname'] . ' ' . $chat['lastname'] ?></span>
          <p><?= $chat['status'] ?></p>
        </div>
      </div>
      <div class="chat_box">

      </div>
      <form action="#" class="typing_area" autocomplete="off">
        <input name="outgoing_id" type="text" value="<?= $unique_id ?>" hidden>
        <input name="incoming_id" type="text" value="<?= $userId ?>" hidden>
        <input name="message" class="input_area" type="text" placeholder="Type message here">
        <button><i class='bx bxl-telegram'></i></button>
      </form>
    </section>
  </div>
<?php endif ?>







<?php
include 'partials/footer.php';
?>