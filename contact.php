<?php
include 'partials/header.php';
?>

<section class="contact">
  <div class="header">
    <div class="header_container">
      <h2>Contact me</h2>
    </div>
  </div>
  <div class="contact__container">
    <div class="contact_left">
      <a href="" class="contact_method">
        <i class='bx bxl-linkedin-square' ></i>
        <span>LinkedIn</span>
      </a>
      <a href="" class="contact_method">
        <i class='bx bxl-instagram' ></i>
        <span>Instagram</span>
      </a>
    </div>

    <div class="contact_right">
      <h3>Or Email me!!</h3>
      <form action="https://formspree.io/f/xdobryzz" method="POST">
        <input type="text" name="name" placeholder="ENTER YOUR NAME">
        <input type="email" name="email" placeholder="ENTER YOUR EMAIL">
        <textarea name="message" id="textarea" placeholder="LEAVE MESSAGES HERE" rows="8"></textarea>
        
        <button class="btn" type="submit">Send</button>
      </form>
      </div>
  </div>
</section>


<?php
include 'partials/footer.php';
?>
