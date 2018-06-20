<?php
/*
 * Template Name: Conheça o Campus
*/
?>

<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/header.php"); ?>
 <!-- CONTENT -->
<div class="container content-container">
  <section role="main">

    <div class="row row-list-courses">

      <?php while (have_posts()): the_post(); ?>
        <article>
          <div class="page-header">
            <h1><span class="fa fa-location-arrow"></span>&nbsp; Conheça o Campus</h1>
          </div>
        
          <div class="col-md-12">              
            <div class="entry-content">
              <?php the_content(); ?>
            </div>
          </div>
        </article>
      
      <?php endwhile; ?>
    </div>

  </section>
<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/footer.php"); ?>
