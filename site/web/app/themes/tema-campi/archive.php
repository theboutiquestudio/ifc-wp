<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/header.php"); ?>
 <!-- CONTENT -->
<div class="container content-container">
  <section role="main">
    <div class="row row-category row-category-news">
      
      <div class="col-md-12">

        <div class="page-subheader">
          <h2 class="section-title"><?php post_type_archive_title(); ?></h2>
        </div><!-- /.page-subheader -->
      
        <?php if (have_posts()): ?>
          <ul class="media-list">
        
            <?php while (have_posts()): the_post(); ?>
              <article>
                <a href="<?php the_permalink() ?>">
                  <li class="media">                
                    <?php if (has_post_thumbnail()): ?>
                      <div class="media-left">
                        <div class="media-img">
                         <?php the_post_thumbnail('small-thumb', array( 'class' => 'img-thumbnail img-responsive' )); ?>
                        </div>
                      </div><!-- /.media-left -->
                    <?php endif; ?>
                    
                    <div class="media-body">
                      <h3 class="media-heading archive">
                        <?php the_title() ?>
                      </h3>
                      
                      <p class="info">
                        <span class="text-muted">[<?php the_time('d/m/Y') ?>]</span>
                        <?php IFC_Func_Global::echo_post_excerpt(55); ?>
                      </p>
                    </div><!-- /.media-body -->
                    
                  </li><!-- /.media -->
                </a>
              </article>
            <?php endwhile; ?>
          </ul><!-- /.media-list -->
        <?php else: ?>
          <p>Sem artigos cadastrados.</p>
        <?php endif; ?>
        
      </div><!-- /.col-md-12 -->

      <!-- PAGINAÇÃO -->
      <div class="text-center">
        <?php IFC_Func_Global::echo_paginacao(); ?>
      </div>
      <!-- /.PAGINAÇÃO -->
    
    </div><!-- /.row-category -->
  
    <br/>

  </section>
<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/footer.php"); ?>
