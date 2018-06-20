<?php 

/**
 * 
 */
class IFC_Avisos
{
	static function exibir_avisos($consulta){
		if ($consulta->have_posts()) {
          while ( $consulta->have_posts() ){
            $consulta->the_post();
            ?>
            <span>[<?php the_time('d/m/Y') ; ?>]</span>
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            <br> 
            <?php 
          } 
          // End the Loop
          
        }else{
        	?>
        	<span>Não há avisos cadastrados</span>
        <?php 
        }
		wp_reset_postdata();
	}
}