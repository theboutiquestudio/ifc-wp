<?php 

/**
* 
*/
class IFC_Acesso_Rapido
{
	public static function mostrar($mostrar_duas_colunas=false){

		?>
		<section class="section-acesso-rapido" role="navigation">
				<div class="text-center menu-acesso-rapido <?php  echo $mostrar_duas_colunas ? "duas-colunas" : ""; ?>">
					<h1 class="section-title">Acesso Rápido</h1>
				 	<?php 
					 	wp_nav_menu(array(
					 		'theme_location' => 'Acesso Rapido',
					 		'fallback_cb' => false,
					 	)); 
				 	?>
				</div>
		</section>
		<?php
	}

}