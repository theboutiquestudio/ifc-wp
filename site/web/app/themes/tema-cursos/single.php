<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/header.php"); ?>
 <!-- CONTENT -->
<div class="container content-container">
  <section role="main">
    
    <div class="row">

      <div class="page-header">
        <h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo(); ?> <small><?php bloginfo('description'); ?></small></a></h1>
      </div><!-- /.page-header -->
      
      <div class="col-md-12">
        <?php require("navbar.php"); ?>
      </div><!-- /.col-md-12 -->

      <div class="col-md-12">
        <?php while (have_posts()): the_post(); ?>
          <article>
            <div class="page-subheader">
              <h2><?php the_title(); ?></h2>
            </div><!-- /.page-subheader -->
            
            <span class="text-muted"><?php the_time('l, j \d\e F \d\e Y'); ?></span><br/><br/>
            
            <div class="entry-content">
              <?php the_content(); ?>
            </div><!-- /.entry-content -->
          </article>
        <?php endwhile; ?>
      </div><!-- /.col-md-12 -->
    </div><!-- /.row -->

  </section>
<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/footer.php"); ?>
