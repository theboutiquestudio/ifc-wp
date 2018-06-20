<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/header.php"); ?>
 <!-- CONTENT -->
<div class="container content-container">
  <section role="main">

    <div class="row row-category row-department-menu">

      <div class="page-header">
        <h1><a href="<?php bloginfo('url'); ?>"><span class="fa fa-files-o"></span> &nbsp;<?php bloginfo(); ?> <small><?php bloginfo('description'); ?></small></a></h1>
      </div><!-- /.page-header -->

      <!-- NAVEGAÇÃO SECUNDÁRIA -->
      <div class="col-md-12">
        <?php require("navbar.php"); ?>
      </div>
      <!-- /NAVEGAÇÃO SECUNDÁRIA -->

      <div class="col-md-12">
        <div class="row">
          <div class="col-md-8">

            <div class="page-subheader">
              <h2><?php single_cat_title(); ?></h2>
            </div><!-- /.page-subheader -->

            <?php if (have_posts()): ?>

              <ul class="media-list">

                <?php while (have_posts()): the_post(); ?>

                  <article>
                    <li class="media">
                      <div class="media-body">
                        <a href="<?php the_permalink() ?>">
                          <h3 class="media-heading">
                            <?php the_title() ?>
                          </h3><!-- /.media-heading -->

                          <p class="info">
                            <?php IFC_Func_Global::echo_post_excerpt(55); ?>
                          </p>
                        </a>

                        <p class="categories">
                          <?php list_categories(); ?>
                        </p>

                      </div><!-- /.media-body -->
                    </li><!-- /.media -->
                  </article>

                <?php endwhile; ?>
              </ul><!-- /.media-list -->

            <?php else: ?>
              <p>Sem artigos cadastrados.</p>
            <?php endif; ?>

          </div><!-- /.col-md-8 -->

          <div class="col-md-4">

            <!-- MENU -->
            <div class="col-menu">
              <?php get_sidebar(); ?>
            </div><!-- /.col-menu -->
            <!-- /.MENU -->

          </div><!-- /.col-md-4 -->

        </div><!-- row -->
      </div><!-- /.col-md-12 -->

      <!-- PAGINAÇÃO -->
      <div class="text-center">
        <?php IFC_Func_Global::custom_paginacao(); ?>
      </div>
      <!-- /.PAGINAÇÃO -->

    </div><!-- row -->

    <br/>

  </section>
<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/footer.php"); ?>
