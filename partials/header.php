<?php
// require 'C:\xampp\htdocs\exp-mgmt\config\database.php';
require './config/database.php';

if(empty($_SESSION['user-id'])) {
  
  header("location: " . ROOT_URL . "signin-page.php");
  exit();
} 

//get current user
if (isset($_SESSION['user-id'])) {
  $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT avatar, firstname, lastname, unique_id FROM users WHERE id = $id";
  $result = mysqli_query($connection, $query);
  $avatar = mysqli_fetch_assoc($result);
}
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
  <script src="https://cdn.tiny.cloud/1/a80twco840weqazu4k74tdqhs52t68ukfz1kzin33g7k2y22/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js" integrity="sha512-YcsIPGdhPK4P/uRW6/sruonlYj+Q7UHWeKfTAkBW+g83NKM+jMJFJ4iAPfSnVp7BKD4dKMHmVSvICUbE/V1sSw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
  <script>
    tinymce.init({
      selector: '#textarea',
      plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
      toolbar: ' bold italic underline strikethrough | blocks | forecolor backcolor | link image blockquote codesample | align bullist numlist | code ',
      editor_css: "/css/style.css",
      content_css: "/css/style.css",
      encoding: 'xml',
      skin: 'snow',
      icons: 'thin',
      content_style: 'body { margin: 1.5rem 10%;}' + 'head {background: #d8f3dc}'
    });
  </script>
</head>

<body>
  <div class="container">
    <div class="navigation">
      <ul>
        <li class="navMenu logo">
          <a href="<?= ROOT_URL ?>index.php">
            <?php if (isset($_SESSION['user-id'])) : ?>
              <span class="initial"><?= $avatar['firstname'][0] . $avatar['lastname'][0] ?></span>
              <span class="title">
                <h2>Hi, <?= $avatar['lastname'] ?></h2>
              </span>
            <?php else : ?>
              <span class="icon"><i class="fa fa-thumbs-up" aria-hidden="true"></i></span>
              <span class="title">
                <h2>Welcome</h2>
              </span>
            <?php endif ?>
          </a>
        </li>
        <li class="navMenu">
          <a href="<?= ROOT_URL ?>" class="navItem">
            <span class="icon"><i class='bx bxs-dashboard' ></i></span>
            <span class="title">Dashboard</span>
          </a>
        </li>
        <li class="navMenu">
          <a href="<?= ROOT_URL ?>transaction-search.php?page=1" class="navItem">
            <span class="icon"><i class='bx bxs-wallet' ></i></span>
            <span class="title">Transaction</span>
          </a>
        </li>
        <li class="navMenu app-btn">
          <a href="javascript:;" class="navItem">
            <span class="icon"><i class='bx bx-desktop' ></i></span>
            <span class="title">Apps</span>
            <span class="fa fa-caret-down first"></span>
          </a>
          <ul class="app-show">
            <li>
              <a href="<?= ROOT_URL ?>apps/image-editor.php" class="navItem">
                <span class="icon"><i class='bx bx-image bx-tada' ></i></span>
                <span class="title">Image Editor</span>
              </a>
            </li>
            <li>
              <a href="<?= ROOT_URL ?>apps/translator.php" class="navItem">
                <span class="icon"><i class='bx bx-text bx-tada' ></i></span>
                <span class="title">Simple Translator</span>
              </a>
            </li>
            <li>
              <a href="<?= ROOT_URL ?>chat.php?user_id=<?= $_SESSION['unique_id'] ?>" class="navItem chat">
                <span class="icon"><i class='bx bx-chat bx-tada' ></i></span>
                <span class="title">Chat</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="navMenu">
          <a href="<?= ROOT_URL ?>contact.php" class="navItem">
            <span class="icon"><i class="fa fa-question-circle" aria-hidden="true"></i></span>
            <span class="title">Contact</span>
          </a>
        </li>
        <li class="navMenu">
          <a href="<?= ROOT_URL ?>settings.php" class="navItem">
            <span class="icon"><i class='bx bxs-cog' ></i></span>
            <span class="title">Settings</span>
          </a>
        </li>
        <?php if (isset($_SESSION['user-id'])) : ?>
          <li class="navMenu">
            <a href="<?= ROOT_URL ?>signout.php?logout_id=<?= $avatar['unique_id'] ?>">
              <span class="icon"><i class="fa fa-sign-out" aria-hidden="true"></i></span>
              <span class="title">Sign Out</span>
            </a>
          </li>
        <?php else : ?>
          <li class="navMenu">
            <a href="<?= ROOT_URL ?>signin.php" class="navItem">
              <span class="icon"><i class="fa fa-sign-in" aria-hidden="true"></i></span>
              <span class="title">Sign In</span>
            </a>
          </li>
          <li class="navMenu">
            <a href="<?= ROOT_URL ?>signup.php" class="navItem">
              <span class="icon"><i class="fa fa-registered" aria-hidden="true"></i></span>
              <span class="title">Register</span>
            </a>
          </li>
        <?php endif ?>
      </ul>
    </div>
    <div class="main">
      <div class="topbar">
        <div class="toggle"></div>
        <div class="feed">
          <i class='bx bx-news'></i>
          <div class="feed_content">
            <script type="text/javascript">
              rssfeed_url = new Array();
              rssfeed_url[0] = "http://myhome.chosun.com/rss/www_section_rss.xml";
              rssfeed_frame_width = "360";
              rssfeed_frame_height = "35";
              rssfeed_scroll = "on";
              rssfeed_scroll_step = "6";
              rssfeed_scroll_bar = "off";
              rssfeed_target = "_blank";
              rssfeed_font_size = "12";
              rssfeed_font_face = "";
              rssfeed_border = "off";
              rssfeed_css_url = "";
              rssfeed_title = "off";
              rssfeed_title_name = "";
              rssfeed_title_bgcolor = "transparent";
              rssfeed_title_color = "#fff";
              rssfeed_title_bgimage = "";
              rssfeed_footer = "off";
              rssfeed_footer_name = "rss feed";
              rssfeed_footer_bgcolor = "#fff";
              rssfeed_footer_color = "#333";
              rssfeed_footer_bgimage = "";
              rssfeed_item_title_length = "25";
              rssfeed_item_title_color = "#fff";
              rssfeed_item_bgcolor = "transparent";
              rssfeed_item_bgimage = "";
              rssfeed_item_border_bottom = "off";
              rssfeed_item_source_icon = "off";
              rssfeed_item_date = "off";
              rssfeed_item_description = "off";
              rssfeed_item_description_length = "120";
              rssfeed_item_description_color = "#666";
              rssfeed_item_description_link_color = "#333";
              rssfeed_item_description_tag = "off";
              rssfeed_no_items = "0";
              rssfeed_cache = "b65601ea8e8062e29542cbcb4d2ccae9";
              //--> 
            </script>
            <script type="text/javascript" src="//feed.surfing-waves.com/js/rss-feed.js"></script>
          </div>


          <!-- <label>
            <input type="text" placeholder="Search">
            <i class="fa fa-search" aria-hidden="true"></i>
          </label> -->
        </div>
        <div class="profile">
          <div class="theme-btn">
            <span id="dayMode" class="fa fa-sun-o active" aria-hidden="true"></span>
            <span id="nightMode" class="fa fa-moon-o" aria-hidden="true"></span>
          </div>
          <div class="user">
            <img src="<?= ROOT_URL . 'images/' . $avatar['avatar'] ?>" alt="">
          </div>
        </div>
      </div>