<?php
$title = "Dashboard";
$page = "";
$mainPage = "Dashboard";
$mainPageUrl = "";
$pageUrl = "";
require_once "components/header.php";

?>

<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <div class="card-title">Form Elements</div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6 col-lg-12">
          <div class="form-group">
            <label for="email2">Email Address</label>
            <input
              type="email"
              class="form-control"
              id="email2"
              placeholder="Enter Email" />
            <small id="emailHelp2" class="form-text text-muted">We'll never share your email with anyone
              else.</small>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input
              type="password"
              class="form-control"
              id="password"
              placeholder="Password" />
          </div>

        </div>

      </div>
    </div>
    <div class="card-action">
      <button class="btn btn-success">Submit</button>
      <button class="btn btn-danger">Cancel</button>
    </div>
  </div>
</div>
</div>

</div>
</div>

<?php require_once "components/footer.php"; ?>