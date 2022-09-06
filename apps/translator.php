<?php
include dirname(__DIR__, 1).'../partials/header.php';
?>

<section class="translator__section">

  <div class="translator__container">
    <h2>Simple Translator</h2>
    <div class="translator__wrapper">
      <div class="text-input">
        <textarea class="from-text" placeholder="Enter Text Here"></textarea>
        <textarea class="to-text" placeholder="Translated Text Here" readonly disabled></textarea>
      </div>
      <ul class="translator__controls">
        <li class="row from">
          <div class="icons">
            <i id="from" class="fa fa-volume-up"></i>
            <i id="from" class="fa fa-copy"></i>
          </div>
          <select id="country_list">

          </select>
        </li>
        <li class="exchange"><i class="fa fa-exchange"></i></li>
        <li class="row to">
          <select id="country_list">

          </select>
          <div class="icons">
            <i id="to" class="fa fa-volume-up"></i>
            <i id="to" class="fa fa-copy"></i>
          </div>
        </li>
      </ul>
    </div>
    <button class="translate-btn">Translate</button>
  </div>
</section>




<?php
include '../partials/footer.php';
?>