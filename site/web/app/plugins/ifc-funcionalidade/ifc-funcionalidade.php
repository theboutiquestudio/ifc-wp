<?php
/*
Plugin Name: Funcionalidade IFC
*/

// Se esse arquivo foi executado diretamente, parar a execução.
if (!defined('WPINC')){
	die;
}


require_once plugin_dir_path(__FILE__) . 'autoload.php';

register_activation_hook(__FILE__, array('IFC_Func', 'ativar'));

register_deactivation_hook(__FILE__, array('IFC_Func', 'desativar'));



function run_ifc_funcionalidade(){
	$plugin = new IFC_Func();
	$plugin->executar();
}

function ifc_mensagem_falta_acf(){
	?>
	<div class="error notice">
		<h2 class="dashicons-before dashicons-warning">
			ERRO CRÍTICO
		</h2>
		<p>
			A configuração atual não permite o funcionamento dos sites nessa <i>network</i>.<br />
			Uma mensagem de erro está sendo exibida para os usuários.
		</p>
		<p>
			<?php if (current_user_can('manage_network_plugins')): ?>
			Para habilitar a funcionalidade dos sites, será necessário ativar o
			plugin Advanced Custom Fields no <a href="<?= network_admin_url('plugins.php') ?>">painel da <i>network</i></a>.
			<?php else: ?>
			<b>Por favor, contate o administrador do sistema.</b>
			<?php endif; ?>
		</p>
	</div>
	<?php
}

function ifc_desabilitar_acesso_fora_admin(){
	if(!is_admin() && !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) {
		wp_die(
			'<h1>Ops, houve um erro ao acessar o site.</h1>
			<p>
				O acesso ao site está temporariamente desabilitado.<br />
				Por favor, volte a tentar mais tarde, ou então entre em contato conosco.
			</p>
			<p style="text-align: center;">
				Instituto Federal de Educação, Ciência e Tecnologia Catarinense<br />
				Rua das Missões, 100 - CEP 89051-000 - Blumenau - SC - Fone (47) 3331-7800
			</p>',
			'IFC - Erro ao acessar o site'
		);
	}
}

function verificar_plugins_dependencias_ativados(){
	// Verificar se os plugins necessários para o funcionamento desse
	// estão presentes e ativos.
	$plugin_acf_ativado = class_exists('ACF');
	return $plugin_acf_ativado;
}

if (verificar_plugins_dependencias_ativados()) {
	run_ifc_funcionalidade();
} else {
	add_action('admin_notices', 'ifc_mensagem_falta_acf');
	add_action('network_admin_notices', 'ifc_mensagem_falta_acf');
	add_action('init', 'ifc_desabilitar_acesso_fora_admin');
}
