<?php


$unique_id = $_SESSION['unique_id'];
$user_id = $_SESSION['user-id'];

$user_query = "SELECT * FROM users where unique_id = $unique_id";
$user_result = mysqli_query($connection, $user_query);
$user = mysqli_fetch_assoc($user_result);

$all_user_query = "SELECT * FROM users WHERE unique_id != $unique_id";
$all_user_result = mysqli_query($connection, $all_user_query);



?>

<?php if(mysqli_num_rows($all_user_result) > 1) : ?>
  <?php while($all_user = mysqli_fetch_assoc($all_user_result)) : ?>
    <a href="<?= ROOT_URL ?>chat.php?user_id=<?= $all_user['unique_id'] ?>">
      <div class="content">
        <img src="<?= ROOT_URL . 'images/' . $all_user['avatar'] ?>" alt="">
        <div class="user_detail">
          <span><?= $all_user['firstname'] . ' ' . $all_user['lastname'] ?></span>
          <?php
            $msg_user_query = "SELECT * FROM messages WHERE (incoming_msg_id = {$all_user['unique_id']} OR outgoing_msg_id = {$all_user['unique_id']}) AND (outgoing_msg_id = {$unique_id} OR outgoing_msg_id = {$unique_id}) ORDER BY id DESC LIMIT 1";
            $msg_user_result = mysqli_query($connection, $msg_user_query);
            
            if (mysqli_num_rows($msg_user_result)>0) {
              $msg_user = mysqli_fetch_assoc($msg_user_result);
              if(strlen($msg_user['msg'])>20) {
                $msg_trimmed = substr($msg_user['msg'], 0, 20) . '...';
              } else {
                $msg_trimmed = $msg_user['msg'];
              }
              echo '<p>'. $msg_trimmed .'</p>';
            } else {
              echo '<p>No message available</p>';
            }
          ?>

          
        </div>
      </div>
      <?php
        if($all_user['status'] === "Offline") {
          $offline = 'offline';
        } else {
          $offline = '';
        }
      ?>
      <div class="status-dot <?= $offline ?>">
        <i class='bx bxs-circle' ></i>
      </div>
    </a>
  <?php endwhile ?>
<?php elseif(mysqli_num_rows($all_user_result) == 1) : ?>
  <a href="#">
    <div class="content">
      <div class="user_detail">
        <span>No user currently available</span>
      </div>
    </div>
  </a>
<?php endif ?>