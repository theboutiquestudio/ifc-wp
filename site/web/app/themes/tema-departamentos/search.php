<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/header.php"); ?>
 <!-- CONTENT -->
<div class="container content-container">
  <section role="main">
            
    <div class="row">
      <div class="page-header">
        <h1><a href="<?php bloginfo('url'); ?>"><span class="fa fa-files-o"></span>&nbsp; <?php bloginfo(); ?> <small><?php bloginfo('description'); ?></small></a></h1>
        <a href="<?php bloginfo('url'); ?>" class="btn btn-default pull-right back-link"><span class="fa fa-arrow-left"></span>&nbsp; Início</a>
      </div>
      
      <div class="col-md-12">
      	<?php require("navbar.php"); ?>
      </div>
    </div>
            
    <?php require(WP_CONTENT_DIR . "/themes/ifc-v2/content-search.php"); ?>
  
    <br/>
  
  </section>
<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/footer.php"); ?>
