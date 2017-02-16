<?php
require_once('functions.php');

if(isset($_POST['username']) && isset($_POST['password'])){
	if($_POST['username'] === APP_USERNAME && $_POST['password'] === APP_PASSWORD){
		$_SESSION['app_username'] = APP_USERNAME;
		$_SESSION['app_password'] = APP_PASSWORD;
		header('Location: ' . r4me_get_directory_url() . '/admin.php');
	}
}

?>


<?php include_once('header.php'); ?>

<div class="r4me-form-top"></div>
<div class="r4me-form-container container">
<form class="form-horizontal" action="" method="POST">
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">User</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="username" name="username" placeholder="User">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="password" name="password" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary">Sign in</button>
    </div>
  </div>
</form>
</div>

<div class="pad50"></div>

<?php include_once('footer.php'); ?>