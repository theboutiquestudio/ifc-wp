<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
      <?php restore_current_blog(); ?>
      <title><?php wp_title(''); ?></title>  
      
      <link type="application/atom+xml" rel="alternate" href="<?php bloginfo('atom_url'); ?>"/>
      <?php switch_to_blog(1); ?>
      
    
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>

    <!-- META WORDPRESS -->
    <?php wp_meta(); ?>
    <!-- /.META WORDPRESS -->

    <!-- HEAD WORDPRESS -->
    <?php wp_head(); ?>
    <!-- /.HEAD WORDPRESS -->
    <link rel="icon" type="image/png" href="<?php echo content_url(); ?>/themes/ifc-v2/assets/images/favicon.png" sizes="any">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link href="<?php echo content_url(); ?>/themes/ifc-v2/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo content_url(); ?>/themes/ifc-v2/components/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo content_url(); ?>/themes/ifc-v2/components/magnific-popup/dist/magnific-popup.css" rel="stylesheet">
    <link href="<?php echo content_url(); ?>/themes/ifc-v2/assets/stylesheets/styles.css" rel="stylesheet">
  </head>

  <body <?php body_class(); ?>>

    <div id="page-canvas">

      <div id="page-content">

             <?php restore_current_blog(); ?>
             <!-- plugin header  -->
             <?php IFC_Header::mostrar(); ?>

