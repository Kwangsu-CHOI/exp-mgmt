<?php
include 'partials/header.php';

$current_user_id = $_SESSION['user-id'];

$transaction_all = "SELECT * FROM transactions WHERE user_id = $current_user_id";
$transaction_all_result = mysqli_query($connection, $transaction_all);

//=================for pagination
if (isset($_GET['page'])) {
  $page = $_GET['page'];
} else {
  $page = 0;
}

$num_per_page = 7;
$start_from = ($page - 1) * 7;

// ===================== for search =======================
// head to a new url with search and page els

//query with taking search input

if (isset($_GET['search'])) {
  $searchKey = $_GET['search'];
  
  $query = "SELECT * FROM transactions WHERE (`title` LIKE '%".$searchKey."%') OR (`location` LIKE '%".$searchKey."%') OR (`description` LIKE '%".$searchKey."%') OR (`amount` LIKE '%".$searchKey."%') AND (`user_id` = $current_user_id) LIMIT $start_from,$num_per_page";
} else {
  $query = "SELECT * FROM transactions WHERE user_id = $current_user_id LIMIT $start_from,$num_per_page";
}
$result = mysqli_query($connection, $query);

// ===  for fetching categories ===
$category_qeury = "SELECT * FROM categories";
$category_result = mysqli_query($connection, $category_qeury);

// === fetching category list for options under add transaction ===
$category_qeury_two = "SELECT * FROM categories";
$category_result_two = mysqli_query($connection, $category_qeury_two);
?>

<section class="transaction__container">

  <?php if (isset($_SESSION['add-category-success'])) : ?>
    <?php
    $msg = $_SESSION['add-category-success'];
    echo "<script type='text/javascript'>alert('$msg');</script>";
    unset($_SESSION['add-category-success']);
    ?>
  <?php endif ?>

  <!-- category list -->
  <h2>Categories</h2>
  <div class="categories">
    <div class="category_list">
      <div class="category_item">
        <span><i id="addIcon" class="fa fa-plus" aria-hidden="true"></i></span>
      </div>
      <?php if (mysqli_num_rows($category_result) > 0) : ?>
        <?php while ($cat = mysqli_fetch_assoc($category_result)) : ?>
          <?php
          // $category_id = $transaction['category_id'];
          // $cat_query = "SELECT title FROM categories";
          // $cat_result = mysqli_query($connection, $cat_query);
          // $cat = mysqli_fetch_assoc($cat_result);
          $ranCol = "#" . rand(10, 100);
          if ($cat['title'] === 'Income') {
            $color = 'border: 3px solid var(--yellow);';
          } else if ($cat['title'] === 'Expense') {
            $color = 'border: 3px solid var(--red);';
          } else {
            $color = 'border: 3px solid var(--random);';
          }
          ?>

          <div class="category_item cat_item">
            <span style="<?= $color ?>"></span>
            <p><?= $cat['title'] ?></p>
            <a href="<?= ROOT_URL ?>delete-category.php?id=<?= $cat['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
          </div>
        <?php endwhile ?>
      <?php else : ?>
        <p>No category available</p>
      <?php endif ?>
    </div>
    <div class="form__add-category" id="addCategory">
      <form class="container__add-category" action="<?= ROOT_URL ?>addCategory-logic.php" enctype="multipart/form-data" method="POST">
        <div class="category-item">
          <label>Title</label>
          <input type="text" name="title" required>
        </div>
        <div class="category-item">
          <label>description</label>
          <input type="text" name="description" required>
        </div>
        <button type="submit" name="submit" class="btn">Add</button>
      </form>
    </div>
  </div>
  <!-- category list end -->

  <!-- transaction grid -->
  <div class="grid_header">
    <h2>Transaction History</h2>
    <div class="calc_toggle"><i class='bx bx-calculator'></i></div>
    <?php include './calculator.php' ?>
  </div>
  <div class="transaction_grid">
    <div class="table_header">
      <div class="reset_search">
        <span>
          <h3>Reset Search</h3>
        </span>
        <span onClick="document.location.href='<?= ROOT_URL ?>transaction-search.php?page=1'"><i class="fa fa-undo" aria-hidden="true"></i></span>
      </div>
      
      <div class="searchBar">
        <form action="search.php" method="POST">
          <input type="text" name="search" placeholder="Search here">
          <button type="submit" name="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
      </div>
    </div>
    <table class="table-sortable" id="export_table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Location</th>
          <th>Description</th>
          <th>Amount</th>
          <th>Category</th>
          <th>Date</th>
          <th class="excluded_column">Edit</th>
          <th class="excluded_column">Delete</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $i = 0;
        while ($transaction = mysqli_fetch_assoc($result)) : ?>
          <?php
          $category_id = $transaction['category_id'];
          $cat_query = "SELECT title FROM categories WHERE id=$category_id";
          $cat_result = mysqli_query($connection, $cat_query);
          $cat = mysqli_fetch_assoc($cat_result);
          ?>
          <tr id="<?= $i++ ?>">
            <td class="row-data">
              <div contenteditable="false" onblur="updateValue(this)" onClick="">
                <?= $transaction['id'] ?>
              </div>
            </td>
            <td class="row-data">
              <div contenteditable="false" onblur="updateValue(this, 'title', '<?= $transaction['id'] ?>' )" onClick="">
                <?= $transaction['title'] ?>
              </div>
            </td>
            <td class="row-data">
              <div contenteditable="false" onblur="updateValue(this, 'location', '<?= $transaction['id'] ?>' )" onClick="">
                <?= $transaction['location'] ?>
              </div>
            </td>
            <td class="row-data">
              <div contenteditable="false" onblur="updateValue(this, 'description', '<?= $transaction['id'] ?>' )" onClick="">
                <?= $transaction['description'] ?>
              </div>
            </td>
            <td class="row-data amount">
              <span>$</span>
              <div contenteditable="false" onblur="updateValue(this, 'amount', '<?= $transaction['id'] ?>' )" onClick="">
                <?= $transaction['amount'] ?>
              </div>
            </td>
            <td><?= $cat['title'] ?></td>
            <td><?= date('d/m/y g:i A', strtotime($transaction['date_time'])) ?></td>
            <td class="editBtn"><a class="edit_btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
            <td class="deleteBtn"><a class="delete_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></td>
          </tr>
        <?php endwhile ?>

      </tbody>

    </table>

    <!-- pagination -->
    <div class="container__page-btn">
      <?php
      if (isset($_GET['search'])) {
        $searchKey = $_GET['search'];
        $page_query = "SELECT * FROM transactions WHERE  user_id = $current_user_id AND id = '$searchKey' OR title LIKE '%$searchKey%'";
      } else {
        $page_query = "SELECT * FROM transactions WHERE user_id = $current_user_id";
      }
      $p_result = mysqli_query($connection, $page_query);

      $total_record = mysqli_num_rows($p_result);
      $total_page = ceil($total_record / $num_per_page);
      if (isset($_GET['search'])) {
        for ($i = 1; $i <= $total_page; $i++) {
          echo '<a class="page-btn" href="http://localhost/exp-mgmt/transaction-search.php?search=' . $_GET['search'] . '&page=' . $i . '">' . $i . ' ' . '</a>';
        }
        echo '<p>Total Search Result: ' . $total_record . '</p>';
      } else {
        for ($i = 1; $i <= $total_page; $i++) {
          echo '<a class="page-btn" href="http://localhost/exp-mgmt/transaction-search.php?page=' . $i . '">' . $i . ' ' . '</a>';
        }
        echo '<p>Total Transaction: ' . $total_record . '</p>';
      }

      ?>
    </div>
    <!-- pagination end -->
  </div>
  <!-- transaction grid end -->

  <div class="download_table">
        <span>
          <h4>Download table as</h4>
        </span>
        <span>
          <i id="export_excel" class="fa fa-file-excel-o" aria-hidden="true"></i>
          <i id="export_pdf" class="fa fa-file-pdf-o" aria-hidden="true"></i>
        </span>
      </div>


  <div class="switch-btn">
    <div>
      <h3>Add new transaction</h3>
    </div>
    <label class="switch">
      <input type="checkbox" id="togBtn">
      <div class="slider round"></div>
    </label>
  </div>
  <div class="form__add-transaction" id="addForm">
    <form class="container__add-transaction" action="<?= ROOT_URL ?>addTransaction-logic.php" enctype="multipart/form-data" method="POST">
      <div class="transaction-item">
        <label>Category</label>
        <select name="category">
          <?php while ($category = mysqli_fetch_assoc($category_result_two)) : ?>
            <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
          <?php endwhile ?>
        </select>
      </div>
      <div class="transaction-item">
        <label>Title</label>
        <input type="text" name="title" required>
      </div>
      <div class="transaction-item">
        <label>Location</label>
        <input type="text" name="location" required>
      </div>
      <div class="transaction-item">
        <label>Amount</label>
        <input type="number" name="amount" required>
      </div>
      <div class="transaction-item">
        <label>Description</label>
        <input type="text" name="description" required>
      </div>
      <div class="transaction-item">
        <label>Date</label>
        <input type="datetime-local" name="date" required>
      </div>
      <button type="submit" name="submit" class="btn">Add</button>
    </form>
  </div>
</section>

<?php
include 'partials/footer.php';
?>