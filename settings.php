<?php
include 'partials/header.php';
?>

<section class="settings__container">
  <div class="picker__container">
    <h2>Change theme color</h2>
    <div class="picker_body">
      <div class="picker_left">
        <div class="color-picker"></div>
        <h5><i class="fa fa-arrow-up" aria-hidden="true"></i> click here to open</h5>
      </div>
      <div class="picker_right">
        <h3>How to change theme color</h3>
        <h4>1. Click the color to open the color palette. </br>
        2. Choose color you want, and click SAVE button to apply </br></br>
        <i class='bx bx-reset'></i> You can reset theme by clicking RESET button.</h4>
      </div>
    </div>
  </div>
  <div class="letter__container">
    <h2>Customise Text</h2>
    <div class="letter_body">
      <div class="letter_left">
        <h3>Change line spacing</h3>
        <div class="line_spacing">
          <button class="line-spacing">1</button>
          <button class="line-spacing">2</button>
          <button class="line-spacing">3</button>
          <i class="line-spacing bx bx-reset"></i>
        </div>
      </div>
      <div class="letter_right">
        <h3>Change text spacing</h3>
        <div class="letter_spacing">
          <button class="letter-spacing">1</button>
          <button class="letter-spacing">2</button>
          <button class="letter-spacing">3</button>
          <button class="letter-spacing">4</button>
          <i class="letter-spacing bx bx-reset"></i>
        </div>
      </div>
    </div>
  </div>
</section>


<?php
include 'partials/footer.php';
?>