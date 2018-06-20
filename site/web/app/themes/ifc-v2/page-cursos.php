<?php
/*
 * Template Name: Lista de Cursos
*/

$terms = get_terms('link_category', 'orderby=id');
?>

<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/header.php"); ?>
 <!-- CONTENT -->
<div class="container content-container">
  <section role="main">

    <div class="row row-list-courses">

      <article>
        <div class="page-header">
          <h1><span class="fa fa-graduation-cap"></span>&nbsp; <?php the_title(); ?></h1>
        </div>
        
        <div class="col-md-12">
          <ul class="list-courses">

            <?php
              foreach ($terms as $term):
                $term_name_segments = explode(' - ', $term->name);
                if ($term_name_segments[0] != 'Lateral') continue;
            ?>
            
              <li>
                <?php echo $term_name_segments[1]; ?> <!-- Nome do tipo de curso -->

                 <ul>
                   <?php wp_list_bookmarks(
                     array(
                       'category_name' => $term->name, // Nome da categoria de links que contém os links desejados
                       'categorize'    => 0,
                       'title_li'      => '',
                       'before'        => '<li><span class="fa fa-angle-right"></span> ',
                       'after'         => '</li>')
                     );
                   ?>
                 </ul>

              </li>    
            
            <?php endforeach; ?>
              
          </ul>
        </div>
      </article>

    </div>

  </section>
<?php require(WP_CONTENT_DIR . "/themes/ifc-v2/footer.php"); ?>
