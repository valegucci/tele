<?php require_once('functions.php');  ?>
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
            <?php include_once('loop-vendors.php'); ?>
         </div>
         <?php include_once('includes/pagination.php'); ?>
         <div class="pad50"></div>
      </div>
   </div>
</div>
<div id="vendor_modal" class="modal fade" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"></h4>
         </div>
         <div class="modal-body">
         </div>
         <div class="modal-footer">
            <a tabindex="0" class="disclosure pull-left" data-container="body" data-toggle="popover" data-placement="right" data-trigger="focus" data-content="The information on this page was manually gathered using publicly available information and is presented as-is for informational and research purposes only. Route4Me's internal team of analysts used all reasonable efforts to represent the information as accurately as possible to identify how industry leading telematics organizations are evolving. If you believe that the information on this website is incorrect, please email <a href='mailto:support@route4me.com'>support@route4me.com</a> with supporting documentation so that we may resolve the discrepancy.">Disclosure</a>
            <a class="btn btn-default" href="">More &raquo;</a>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div id="r4me_token" data-token="<?php r4me_set_token(); ?>"></div>
<?php include_once('footer.php'); ?>