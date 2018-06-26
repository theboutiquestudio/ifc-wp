<?php $has_categories = (count(get_categories())) > 1 ? true : false; ?>

<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/header.php"); ?>

<!-- CONTENT -->

<div class="container content-container">
<section role="main">

  <div class="row row-category row-department-menu">

    <div class="page-header">
      <h1><span class="fa fa-files-o"></span> &nbsp;<?php bloginfo(); ?> <small><?php bloginfo('description'); ?></small></h1>
      <a href="<?php bloginfo('url'); ?>" class="btn btn-default pull-right back-link"><span class="fa fa-arrow-left"></span>&nbsp; Início</a>
    </div><!-- /.page-header -->

		<div class="col-md-12">
			<?php require("navbar.php"); ?>
		</div>

    <div class="<?php echo $has_categories ? 'col-md-8' : 'col-md-12'; ?> col-content white-space">

      <ul class="media-list">

        <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <article>
              <li class="media">
                <div class="media-body">
                  <a href="<?php the_permalink() ?>">
                    <h2 class="media-heading">
                      <?php the_title() ?>
                    </h2>
                    <p class="info">
                      <?php IFC_Func_Global::echo_post_excerpt(55); ?>
                    </p>
                  </a>

                  <p class="categories">
                    <?php IFC_Func_Site_Setor::listar_categorias(); ?>
                  </p>

                </div>
              </li>
            </article>
        <?php endwhile?>
        <?php else: ?>
          <p>Sem artigos cadastrados.</p>
        <?php endif; ?>
      </ul>
    </div><!-- /.col-content -->

    <div class="hidden-md hidden-lg">
      <!-- PAGINAÇÃO -->
      <div class="text-center">
        <?php IFC_Func_Global::echo_paginacao(); ?>
      </div>
      <!-- /.PAGINAÇÃO -->
    </div>

    <!-- CATEGORIAS -->
    <?php if($has_categories): ?>
      <div class="col-md-4 col-menu">
        <nav role="navigation">
          <?php get_sidebar(); ?>
        </nav>
      </div><!-- /.col-menu -->
    <?php endif; ?>
    <!-- /.CATEGORIAS -->

  </div><!-- /.row-department-menu -->

  <div class="hidden-xs hidden-sm">
    <!-- PAGINAÇÃO -->
    <div class="text-center">
      <?php IFC_Func_Global::echo_paginacao(); ?>
    </div>
    <!-- /.PAGINAÇÃO -->
  </div>

</section>
<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/footer.php"); ?>