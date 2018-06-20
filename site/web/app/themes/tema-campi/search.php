<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/header.php"); ?>
 <!-- CONTENT -->
<div class="container content-container">
  <section role="main">

    <div class="row">
      <div class="page-header">
        <h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo(); ?> <small><?php bloginfo('description'); ?></small></a></h1>
      </div><!-- /.page-header -->
      
    </div><!-- /.row -->
    
    <?php require(WP_CONTENT_DIR . "/themes/ifc-v2/content-search.php"); ?>
  
    <br/>
  
  </section>
<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/footer.php"); ?>
