<?php

/**
 * 
 */
class IFC_Eventos
{
	static function exibir_eventos($consulta){
		if ($consulta->have_posts()) {
          while ( $consulta->have_posts() ){
            $consulta->the_post();
            ?>
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            <br> 
            <?php 
          } 
          
        }else{
        	?>
        	<span>Não há eventos cadastrados</span>
        <?php 
        }
		wp_reset_postdata();
	}
}