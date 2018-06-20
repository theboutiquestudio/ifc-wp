<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/header.php"); ?>

<!-- CONTENT -->

<div class="container content-container">
<section role="main">

  <div class="row">
    
    <div class="page-header">
      <h1><a href="<?php bloginfo('url'); ?>"><span class="fa fa-files-o"></span> &nbsp;<?php bloginfo(); ?> <small><?php bloginfo('description'); ?></small></a></h1>
    </div>
    
		<div class="col-md-12">
			<?php require("navbar.php"); ?>
		</div>
    
    <div class="col-md-12">
      <?php while (have_posts()): the_post(); ?>
        <article>
          <div class="page-subheader">
            <h2><?php the_title(); ?></h2>
          </div>
        
          <div class="entry-content">
            <?php the_content(); ?>
          </div>
        </article>
			<?php endwhile; ?>
    </div>
  </div>

</section>
<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/footer.php"); ?>
