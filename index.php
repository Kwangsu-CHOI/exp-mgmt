<?php
include 'partials/header.php';

$unique_id = $_SESSION['unique_id'];
$user_id = $_SESSION['user-id'];
//transationcs
$transaction_query = "SELECT * FROM transactions WHERE user_id = $user_id";
$transaction_result = mysqli_query($connection, $transaction_query);

//total income
if (mysqli_num_rows($transaction_result) > 0) {
  $inc_sum_query = "SELECT sum(amount) as amount FROM transactions WHERE category_id = 1 AND user_id = $user_id GROUP BY category_id";
  $inc_sum_result = mysqli_query($connection, $inc_sum_query);
  if (mysqli_num_rows($inc_sum_result) > 0) {
    $inc_sum = mysqli_fetch_object($inc_sum_result);
  } else {
    $empty = '$0';
  }
} else {
  $empty = '$0';
}

//total expense
if (mysqli_num_rows($transaction_result) > 0) {
  $exp_sum_query = "SELECT sum(amount) as amount FROM transactions WHERE category_id = 2 AND user_id = $user_id  GROUP BY category_id";
  $exp_sum_result = mysqli_query($connection, $exp_sum_query);
  if (mysqli_num_rows($exp_sum_result) > 0) {
    $exp_sum = mysqli_fetch_object($exp_sum_result);
  } else {
    $empty = '$0';
  }
} else {
  $empty = '$0';
}

if (mysqli_num_rows($transaction_result) > 0) {
  if (mysqli_num_rows($inc_sum_result) > 0 && mysqli_num_rows($exp_sum_result) === 0) {
    $bal = intval($inc_sum->amount);
  } elseif (mysqli_num_rows($exp_sum_result) > 0 && mysqli_num_rows($inc_sum_result) === 0) {
    $bal = intval($exp_sum->amount);
  } elseif (mysqli_num_rows($inc_sum_result) > 0 && mysqli_num_rows($exp_sum_result) > 0) {
    $bal = intval($inc_sum->amount) - intval($exp_sum->amount);
  } else {
    $empty = '$0';
  }
} else {
  $empty = '$0';
}

//query for most frequent transaction
$freq_query = "SELECT categories.title AS title, COUNT(category_id) AS count FROM transactions JOIN categories ON category_id = categories.id WHERE user_id = $user_id GROUP BY category_id ORDER BY count DESC LIMIT 1";
$freq_result = mysqli_query($connection, $freq_query);
if (mysqli_num_rows($freq_result) > 0) {
  $freq = mysqli_fetch_assoc($freq_result);
} else {
  $na = 'No transaction available';
}

//query for recent transaction
$user_id = $_SESSION['user-id'];
$query = "SELECT transactions.title AS Title, transactions.location AS Location, transactions.amount AS Amount, categories.title AS Category FROM transactions JOIN categories ON transactions.category_id = categories.id WHERE user_id = $user_id ORDER BY transactions.date_time ASC LIMIT 5";
$result = mysqli_query($connection, $query);

//query for user lists and message
//user list
$all_user_query = "SELECT * FROM users WHERE NOT unique_id = $unique_id";
$all_user_result = mysqli_query($connection, $all_user_query);

//recent msg
$msg_query = "WITH ranked_messages AS (
  SELECT m.*, users.firstname, users.lastname, users.avatar, ROW_NUMBER() OVER (PARTITION BY incoming_msg_id ORDER BY id DESC) AS rn
  FROM messages AS m join users on incoming_msg_id = users.unique_id 
)
SELECT * FROM ranked_messages WHERE rn = 1 AND outgoing_msg_id = $unique_id";
$msg_result = mysqli_query($connection, $msg_query);


?>


<div class="cardBox">
  <div class="card">
    <div class="iconBox">
      <i class="fa fa-line-chart" aria-hidden="true"></i>
    </div>
    <div>
      <?php if (mysqli_num_rows($transaction_result) > 0 && mysqli_num_rows($inc_sum_result) > 0) : ?>
        <div class="numbers"><?= '$' . $inc_sum->amount ?></div>
      <?php else : ?>
        <div class="numbers"><?= $empty ?></div>
      <?php endif ?>
      <div class="cardName">Total Income</div>
    </div>
    <span class="tooltiptext">
      <?php
      $mni_query = "SELECT title, MAX(amount) AS MAX, MIN(amount) AS MIN FROM transactions WHERE category_id = 1 AND user_id = $user_id";
      $mni_result = mysqli_query($connection, $mni_query);
      $mni = mysqli_fetch_assoc($mni_result);

      echo 'Highest Income: ' . $mni['title'] . ', $' . $mni['MAX'] . '<br>';
      echo 'Lowest Income: ' . $mni['title'] . ', $' . $mni['MIN'];
      ?>
    </span>
  </div>
  <div class="card">
    <div class="iconBox">
      <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
    </div>
    <div>
      <?php if (mysqli_num_rows($transaction_result) > 0 && mysqli_num_rows($exp_sum_result) > 0) : ?>
        <div class="numbers"><?= '-$' . $exp_sum->amount ?></div>
      <?php else : ?>
        <div class="numbers"><?= $empty ?></div>
      <?php endif ?>
      <div class="cardName">Total Expense</div>
    </div>
    <span class="tooltiptext">
      <?php
      $mne_query = "SELECT title, MAX(amount) AS MAX, MIN(amount) AS MIN FROM transactions WHERE category_id = 2 AND user_id = $user_id";
      $mne_result = mysqli_query($connection, $mne_query);
      $mne = mysqli_fetch_assoc($mne_result);

      echo 'Highest Expense: ' . $mne['title'] . ', -$' . $mne['MAX'] . '<br>';
      echo 'Lowest Expense: ' . $mne['title'] . ', -$' . $mne['MIN'];
      ?>
    </span>
  </div>
  <div class="card">
    <div class="iconBox">
      <i class="fa fa-balance-scale" aria-hidden="true"></i>
    </div>
    <div>
      <?php if (mysqli_num_rows($transaction_result) > 0) : ?>
        <div class="numbers">
          <?php if ($bal < 0) {
            echo substr($bal, 0, 1) . '$' . substr($bal, 1);
          } elseif (mysqli_num_rows($inc_sum_result) === 0 && mysqli_num_rows($exp_sum_result) > 0) {
            echo '-$' . $bal;
          } else {
            echo '$' . $bal;
          }
          ?>
        </div>
      <?php else : ?>
        <div class="numbers"><?= $empty ?></div>
      <?php endif ?>
      <div class="cardName">Balance</div>
    </div>
  </div>
  <div class="card freq">
    <div class="iconBox">
      <?php if (mysqli_num_rows($freq_result) > 0) : ?>
        <?php if ($freq['title'] === 'Income') : ?>
          <i class='bx bx-money'></i>
        <?php elseif ($freq['title'] === 'Expense') : ?>
          <i class='bx bx-credit-card-alt'></i>
        <?php else : ?>
          <i class='bx bx-question-mark'></i>
        <?php endif ?>
        <div class="numbers"><?= $freq['title'] . ':' ?></div>
        <div class="numbers"><?= $freq['count'] ?></div>
      <?php else : ?>
        <div class="na"><?= $na ?></div>
      <?php endif ?>
    </div>
    <div>
      <div class="cardName">Most frequent transaction</div>
    </div>
  </div>
</div>

<?php if (mysqli_num_rows($transaction_result) > 0) : ?>
  <?php include './charts.php'; ?>
<?php else : ?>
  <div class="alert_msg">
    <a href="<?= ROOT_URL ?>transaction-search.php?page=1">
      <i class='bx bxs-hand-up'></i>
      <p>Please add transaction to create the charts!!</p>
    </a>
  </div>
<?php endif ?>

<div class="details">
  <div class="recentOrders">
    <div class="cardHeader">
      <h2>Recent Incomes & Expenses</h2>
      <a href="<?= ROOT_URL ?>transaction-search.php?page=1" class="btn">View All</a>
    </div>
    <table>
      <thead>
        <tr>
          <td>Title</td>
          <td>Amount</td>
          <td>Location</td>
          <td>Category</td>
        </tr>
      </thead>
      <tbody>
        <?php if(mysqli_num_rows($result)> 0) : ?>
          <?php while ($transaction = mysqli_fetch_assoc($result)) : ?>
            <tr>
              <td><?= $transaction['Title'] ?></td>
              <td>
                <?php if ($transaction['Category'] === 'Income') {
                  echo '$' . $transaction['Amount'];
                } else {
                  echo '-$' . $transaction['Amount'];
                }
                ?>
              </td>
              <td><?= $transaction['Location'] ?></td>
              <td>
                <?php
                if ($transaction['Category'] === 'Income') {
                  $stat = 'status income';
                } else if ($transaction['Category'] === 'Expense') {
                  $stat = 'status expense';
                } else if ($transaction['Category'] === 'Uncategorised') {
                  $stat = 'status uncategorized';
                } else {
                  $stat = 'status etc';
                }
                ?>
                <span class="<?= $stat ?>"><?= $transaction['Category'] ?></span>
              </td>
            </tr>
          <?php endwhile ?>
        <?php else : ?>
          <tr>
            <td>
              <h4>No recent transaction available</h4>
            </td>
          </tr>
        <?php endif ?>
      </tbody>
    </table>
  </div>
  <div class="recentCustomers">
    <div class="cardHeader">
      <h2>Recent Chat</h2>
    </div>
    <table>
      <tbody>
        <?php if (mysqli_num_rows($msg_result) > 0) : ?>
          <?php while ($all_msg = mysqli_fetch_assoc($msg_result)) : ?>
            <?php if ($all_msg['incoming_msg_id'] != $unique_id) : ?>
              <tr>
                <td width="60px">
                  <div class="imgBx"><img src="<?= ROOT_URL ?>/images/<?= $all_msg['avatar'] ?>" alt=""></div>
                </td>
                <td>
                  <h4><?= $all_msg['firstname'] . " " . $all_msg['lastname'] ?><br>
                    <span>
                      <?php
                      echo $all_msg['msg'];
                      ?>
                    </span>
                  </h4>
                </td>
              </tr>
            <?php endif ?>
          <?php endwhile ?>
        <?php else : ?>
          <tr>
            <td>
              <h4>No message available
              </h4>
            </td>
          </tr>
        <?php endif ?>
      </tbody>
    </table>
  </div>
</div>


</div>


</div>
<?php
include 'partials/footer.php';
?>