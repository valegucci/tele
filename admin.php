<?php 
   require_once('functions.php');
   
   if(!r4me_user_logged_in()){
     header('Location: ' . r4me_get_directory_url() . '/login.php');
     exit();
   }
   ?>
<?php include_once('header.php'); ?>
<div class="container main-content">
   <div class="row">
      <div class="col-sm-5 col-md-4 left-pane">
         <?php include_once('sidebar.php'); ?>
      </div>
      <div class="col-sm-7 col-md-8 right-pane">
         <h1 class="page-title">Telematics Vendors</h1>
         <div class="pad20"></div>
         <div class="row companies-list">
            <?php include_once('admin-loop.php'); ?>
         </div>
         <?php include_once('includes/pagination.php'); ?>
      </div>
   </div>
</div>
<div id="r4me_token" data-token="<?php r4me_set_token(); ?>"></div>
<?php include_once('footer.php'); ?>