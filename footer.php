<footer><?php echo file_get_contents("https://route4me.com/global-footer.php?protected"); ?></footer>

<div id="r4me_preloader"></div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="<?php echo r4me_get_directory_url(); ?>/js/readmore.min.js"></script>
    <?php if(r4me_is_page('add-new.php') || r4me_is_page('edit.php')): ?>
      <script src="js/chosen.js?ver=1.0.1"></script>
      <script>
      	;(function ($) {
      	$('.vendorFeaturesSelect, .vendorCountriesSelect').chosen({no_results_text: "Oops, nothing found!"}); 
      	}(jQuery));
      </script>
    <?php endif; ?>
    <?php if(r4me_is_page('admin.php')): ?>
    <script src="js/bootstrap-notify.min.js?ver=1.0.0"></script>
    <script>
    ;(function ($) {
      $('.r4me-vendor-delete').on("click", function(e){
          var $dis = $(this);
          e.preventDefault();
          if(window.confirm("Are you sure?")){
            var data = {vendor_id: $dis.data('id')};
            $.post('delete.php', data,
                function(response){
                    if(!$.isEmptyObject(response)){
                        $('#r4me_preloader').html('');
                    }
                    $.notify({
                      message: response 
                    },{
                      type: 'danger'
                    });
                    $dis.parents('.vendor').fadeOut();
            });
          }
        });
    }(jQuery));
      </script>
    <?php endif; ?>
    <script src="<?php echo r4me_get_directory_url(); ?>/js/script.js?ver=1.0.5"></script>
  </body>
</html>