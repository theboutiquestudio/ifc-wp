<?php
/*
 * Template Name: Página Inicial
*/
?>

<?php $has_categories = (count(get_categories())) > 1 ? true : false; ?>

<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/header.php"); ?>

<!-- CONTENT -->

<div class="container content-container">
<section role="main">
          
  <div class="row row-department-menu">
    
    <div class="page-header">
      <h1><span class="fa fa-files-o"></span> &nbsp;<?php bloginfo(); ?> <small><?php bloginfo('description'); ?></small></h1>
    </div>
    
		<div class="col-md-12">
			<?php require("navbar.php"); ?>
		</div>
		
    <div class="<?php echo $has_categories ? 'col-md-8' : 'col-md-12'; ?> col-content white-space">
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
    </div><!-- /.col-content -->

    <!-- CATEGORIAS -->
		<?php if($has_categories): ?>
      <div class="col-md-4 col-menu">
        <nav role="navigation">
  				<?php get_sidebar(); ?>
        </nav>
      </div><!-- /.col-menu -->
		<?php endif; ?>
    <!-- /CATEGORIAS -->
    
  </div><!-- /.row-department-menu -->

</section>
<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/footer.php"); ?>

