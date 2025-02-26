<?php
require_once("components/header.php");
if ($conMessage):
  require_once "backend/submit_contact.php";
endif;
?>

<section class="hero-wrap hero-wrap-2 ftco-degree-bg js-fullheight" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
      <div class="col-md-9 ftco-animate pb-5 text-center">
        <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Contact <i class="ion-ios-arrow-forward"></i></span></p>
        <h1 class="mb-3 bread">Contact us</h1>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section contact-section">
  <div class="container">
    <div class="row d-flex mb-5 contact-info justify-content-center">
      <div class="col-md-8">
        <div class="row mb-5">
          <div class="col-md-4 text-center py-4">
            <div class="icon">
              <span class="icon-map-o"></span>
            </div>
            <p><span>Address:</span> 198 West 21th Street, Suite 721 New York NY 10016</p>
          </div>
          <div class="col-md-4 text-center border-height py-4">
            <div class="icon">
              <span class="icon-mobile-phone"></span>
            </div>
            <p><span>Phone:</span> <a href="tel://1234567920">+ 1235 2355 98</a></p>
          </div>
          <div class="col-md-4 text-center py-4">
            <div class="icon">
              <span class="icon-envelope-o"></span>
            </div>
            <p><span>Email:</span> <a href="../../cdn-cgi/l/email-protection.htm#f1989f979eb1889e848382988594df929e9c"><span class="__cf_email__" data-cfemail="177e797178576e786265647e63723974787a">[email&#160;protected]</span></a></p>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
      <?php endif; ?>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
    </div>
    <div class="row block-9 justify-content-center mb-5">
      <div class="col-md-8 mb-md-5">
        <h2 class="text-center">If you got any questions <br>please do not hesitate to send us a message</h2>
        <form action="" method="POST" class="bg-light p-5 contact-form">

          <div class="form-group">
            <input type="text" name="name" class="form-control" placeholder="Your Name" value="<?php echo htmlspecialchars($name ?? ''); ?>">
          </div>
          <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo htmlspecialchars($email ?? ''); ?>">
          </div>
          <div class="form-group">
            <input type="text" name="subject" class="form-control" placeholder="Subject" value="<?php echo htmlspecialchars($subject ?? ''); ?>">
          </div>
          <div class="form-group">
            <textarea name="message" cols="30" rows="7" class="form-control" placeholder="Message"><?php echo htmlspecialchars($message ?? ''); ?></textarea>
          </div>
          <div class="form-group">
            <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
          </div>
        </form>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-10">
        <div id="map" class="bg-white"></div>
      </div>
    </div>
  </div>
</section>

<?php include_once "components/footer.php" ?>