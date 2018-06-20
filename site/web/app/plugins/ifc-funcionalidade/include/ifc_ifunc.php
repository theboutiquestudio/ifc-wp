<?php


interface IFC_iFunc {

	/**
	 * Executa a cada inicialização do WordPress, ou seja,
	 * a cada página carregada.
	 *
	 * Usar para registrar actions e filters para modificações
	 * dinâmicas que interagem com as globais do WordPress, como:
	 *
	 * - Registrar posições de sidebars e de menus
	 * - Registrar post types
	 *
	 */
	public function executar();

	/**
	 * Executa somente quando o plugin é ativado.
	 * É executado no contexto global (site padrão da network)
	 *
	 * Usar para realizar modificações permanentes,
	 * que alteram o banco de dados, e não se aplicam somente
	 * e diretamente a um (tipo) de site e seu contexto
	 *
	 * - Criar tabelas no banco de dados
	 *
	 */
	public static function ativarGlobal();
	
	/**
	 * Executa somente quando o plugin é ativado.
	 * É executado no contexto de um site específico.
	 *
	 * Usar para realizar modificações permanentes,
	 * que alteram o banco de dados, e se aplicam somente
	 * e diretamente a um (tipo) de site e seu contexto
	 *
	 * - Criar posts, páginas, e categorias
	 *
	 */
	public static function ativarEmSite();

	/**
	 * Executa somente quando o plugin é desativado.
	 * Funciona similarmente ao método ativarGlobal()
	 *
	 * Usar para:
	 *
	 * - Remover tableas no banco de dados
	 *
	 */
	public static function desativarGlobal();
	
	/**
	 * Executa somente quando o plugin é desativado.
	 * Funciona similarmente ao método ativarEmSite()
	 *
	 * - Limpar categorias
	 *
	 */
	public static function desativarEmSite();

}