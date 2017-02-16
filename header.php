<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=.75, user-scalable=no">    
    <title>Route4Me Telematics Vendors</title>
    <link rel="shortcut icon" type="<?php echo r4me_get_directory_url(); ?>/image/ico" href="img/favicon.ico">
    <link rel="name" type="image/png" href="<?php echo r4me_get_directory_url(); ?>/img/favicon.ico">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <?php if(r4me_is_page('add-new.php') || r4me_is_page('edit.php')): ?>
      <link rel="stylesheet" href="css/chosen.css?ver=1.0.0" >
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo r4me_get_directory_url(); ?>/css/style.css?ver=1.1.1" >

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
 <header id="header" >
  <div class="container">
    <img src="<?php echo r4me_get_directory_url(); ?>/img/logo.png" alt="Route4Me"/>
  </div>
</header>