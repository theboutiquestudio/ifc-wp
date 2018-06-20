<?php

class IFC_Func{
	private $func_global;
	private $func_site_geral;
	private $func_site_noticias;
	private $func_site_campus;
	private $func_site_curso;

	public function __construct(){
		$this->func_global = new IFC_Func_Global();
		$this->func_site_geral = new IFC_Func_Site_Geral();
		$this->func_site_noticias = new IFC_Func_Site_Noticias();
		$this->func_site_campus = new IFC_Func_Site_Campus();
		$this->func_site_curso = new IFC_Func_Site_Curso();
		$this->func_site_departamento = new IFC_Func_Site_Departamento();
	}

	/**
	 * Executa a cada inicialização do WordPress, ou seja,
	 * a cada página carregada.
	 *
	 * Mais detalhes nos métodos dos componentes.
	 */
	public function executar(){
		add_action('plugins_loaded', array($this, '_executar'));
	}

	public function _executar(){
		$this->func_global->executar();
		if ($this->is_current_site('geral')){
			$this->func_site_geral->executar();
		} else if ($this->is_current_site('noticias')){
			$this->func_site_noticias->executar();
		} else if ($this->is_current_site('campus')){
			$this->func_site_campus->executar();
		} else if ($this->is_current_site('curso')){
			$this->func_site_curso->executar();
		} else if ($this->is_current_site('departamento')){
			$this->func_site_departamento->executar();
		}
	}

	/**
	 * Executa somente quando o plugin é ativado.
	 *
	 * Mais detalhes nos métodos dos componentes.
	 */
	public static function ativar(){
		self::ativarGlobal();
		self::ativarEmCadaSite();
	}

	public static function ativarGlobal(){
		IFC_Func_Global::ativarGlobal();
		IFC_Func_Site_Geral::ativarGlobal();
		IFC_Func_Site_Noticias::ativarGlobal();
		IFC_Func_Site_Campus::ativarGlobal();
		IFC_Func_Site_Curso::ativarGlobal();
		IFC_Func_Site_Departamento::ativarGlobal();
	}

	public static function ativarEmCadaSite(){
		global $wpdb;

		foreach ($wpdb->get_col("SELECT blog_id FROM $wpdb->blogs") as $blog_id) {
			switch_to_blog($blog_id);
			IFC_Func_Global::ativarEmsite();
			if (self::is_current_site('geral')){
				IFC_Func_Site_Geral::ativarEmSite();
			} else if (self::is_current_site('noticias')){
				IFC_Func_Site_Noticias::ativarEmSite();
			} else if (self::is_current_site('campus')){
				IFC_Func_Site_Campus::ativarEmSite();
			} else if (self::is_current_site('curso')){
				IFC_Func_Site_Curso::ativarEmSite();
			} else if (self::is_current_site('departamento')){
				IFC_Func_Site_Departamento::ativarEmSite();
			}
			restore_current_blog();
		}
	}

	/**
	 * Executa somente quando o plugin é desativado.
	 *
	 * Mais detalhes nos métodos dos componentes.
	 */
	public static function desativar(){
		self::desativarEmCadaSite();
		self::desativarGlobal();
	}

	public static function desativarGlobal(){
		IFC_Func_Global::desativarGlobal();
		IFC_Func_Site_Geral::desativarGlobal();
		IFC_Func_Site_Noticias::desativarGlobal();
		IFC_Func_Site_Campus::desativarGlobal();
		IFC_Func_Site_Curso::desativarGlobal();
		IFC_Func_Site_Departamento::desativarGlobal();
	}

	public static function desativarEmCadaSite(){
		global $wpdb;

		foreach ($wpdb->get_col("SELECT blog_id FROM $wpdb->blogs") as $blog_id) {
			switch_to_blog($blog_id);
			IFC_Func_Global::ativarEmSite();
			if (self::is_current_site('geral')){
				IFC_Func_Site_Geral::desativarEmSite();
			} else if (self::is_current_site('noticias')){
				IFC_Func_Site_Noticias::desativarEmSite();
			} else if (self::is_current_site('campus')){
				IFC_Func_Site_Campus::desativarEmSite();
			} else if (self::is_current_site('curso')){
				IFC_Func_Site_Curso::desativarEmSite();
			} else if (self::is_current_site('departamento')){
				IFC_Func_Site_Departamento::desativarEmSite();
			}

			restore_current_blog();
		}
	}

	public static function is_current_site($site){
		global $wpdb;
		if ($site === 'geral'){
			return is_main_site(null, 1);
		} else if ($site === 'noticias'){
			$nomes = explode('.', get_blog_details()->domain);
			return in_array('noticias', $nomes);
		} else if ($site === 'campus'){
			$id_rede_atual = get_network()->id;
			return $id_rede_atual != 1 && is_main_site();
		} else if ($site === 'curso'){
			$prefix = $wpdb->base_prefix . 'ifc_';
			$curso_row = $wpdb->get_row($wpdb->prepare(
				"SELECT blog_id FROM {$prefix}cursos WHERE blog_id = %d",
				get_current_blog_id()
			));
			return $curso_row !== null;
		} else if ($site === 'departamento'){
			$prefix = $wpdb->base_prefix . 'ifc_';
			$departamento_row = $wpdb->get_row($wpdb->prepare(
				"SELECT blog_id FROM {$prefix}departamentos WHERE blog_id = %d",
				get_current_blog_id()
			));
			return $departamento_row !== null;
		}
	}
}