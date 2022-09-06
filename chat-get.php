<?php
  require './config/database.php';
  
  if(isset($_SESSION['unique_id'])) {
    $outgoing_id = mysqli_real_escape_string($connection, $_POST['outgoing_id']);
    $incoming_id = mysqli_real_escape_string($connection, $_POST['incoming_id']);
    $output = '';

    $msg_query = "SELECT * FROM messages WHERE (outgoing_msg_id = $outgoing_id AND incoming_msg_id = $incoming_id) OR (outgoing_msg_id = $incoming_id AND incoming_msg_id = $outgoing_id) ORDER BY id asc";
    $msg_result = mysqli_query($connection, $msg_query);

    $user_unique_id = $_SESSION['unique_id'];
    

    $user_unique_id = "SELECT * FROM users WHERE unique_id = $incoming_id";
    $user_msg_result = mysqli_query($connection, $user_unique_id);
    $user_msg = mysqli_fetch_assoc($user_msg_result);

    if(mysqli_num_rows($msg_result)>0) {
      while($msg = mysqli_fetch_assoc($msg_result)) {
        if($msg['outgoing_msg_id'] === $outgoing_id) {
          $output .= '<div class="chat outgoing">
                        <div class="user_detail">
                          <p>'. $msg['msg'] .'</p>
                        </div>
                      </div>';
        } else {
          $output .= '<div class="chat incoming">
                        <img src="'. ROOT_URL . 'images/' . $user_msg['avatar'] .'" alt="">
                        <div class="user_detail">
                          <p>'. $msg['msg'] .'</p>
                        </div>
                      </div>';
        }
      }
    }
    echo $output;
  }


?>