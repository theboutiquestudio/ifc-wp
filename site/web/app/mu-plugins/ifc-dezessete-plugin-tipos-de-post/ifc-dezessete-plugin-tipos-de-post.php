<?php
/*
Plugin Name:  Registrar Tipos de Post
Plugin URI:   https://ifc.edu.br/
Description:  Registra os tipos de posts (notícias, avisos, ...)
Version:      0.1
Author:       IFC
Author URI:   https://ifc.edu.br/
*/

class RegistradorPosts {

    function __construct() {
        register_activation_hook(__FILE__, array($this, 'ativar'));
        add_action('init', array($this, 'criarTipos'));
        add_action('admin_menu', array($this, 'removerPostMenuAdmin'));
    }

    function ativar(){
        $this->criarTipos();
        flush_rewrite_rules();
    }

    /**
    * Cria os CPTs
    */
    function criarTipos(){
        $tipos = array(
            'noticia' => array(
                'labels' => array(
                    'name' => 'Notícia',
                    'plural' => 'Notícias',
                    'add_new' => 'Adicionar nova',
                    'add_new_item' => 'Adicionar nova notícia',
                    'edit_item' => 'Editar notícia',
                    'new_item' => 'Nova notícia',
                    'view_item' => 'Visualizar notícia',
                    'view_items' => 'Visualizar notícias',
                    'search_items' => 'Pesquisar notícias',
                    'not_found' => 'Nenhuma notícia foi encontrada',
                    'not_found_in_trash' => 'Nenhum notícia foi encontrada na lixeira',
                    'all_items' => 'Todas as notícias',
                    'archives' => 'Arquivo de notícias',
                    'attributes' => 'Atributos da notícia',
                    'insert_into_item' => 'Inserir na notícia',
                    'uploaded_to_this_item' => 'Carregado para essa notícia',
                    'featured_image' => 'Imagem destacada',
                    'set_featured_image' => 'Definir imagem destacada',
                    'remove_featured_image' => 'Remover imagem destacada',
                    'use_featured_image' => 'Usar como imagem destacada',
                    'menu_name' => 'Notícias',
                    'filter_items_list' => 'Filtrar lista de notícias',
                    'items_list_navigation' => 'Navegação da lista de notícias',
                    'items_list' => 'Lista de notícias'
                ),
                'public' => true,
                'show_ui' => true,
                'menu_position' => 5,
                'capability_type' => array('noticia', 'noticias'),
                'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions'),
                'taxonomies' => array('category'),
                'has_archive' => true,
                'rewrite' => array('slug' => 'noticia'),
                'delete_with_user' => false
            ),
            'avisos' => array(
                'labels' => array(
                    'name' => 'Aviso',
                    'plural' => 'Avisos',
                    'add_new' => 'Adicionar novo',
                    'add_new_item' => 'Adicionar novo aviso',
                    'edit_item' => 'Editar aviso',
                    'new_item' => 'Novo aviso',
                    'view_item' => 'Ver aviso',
                    'view_items' => 'Var avisos',
                    'search_items' => 'Pesquisar avisos',
                    'not_found' => 'Nenhum aviso foi encontrado',
                    'not_found_in_trash' => 'Nenhum aviso foi encontrado na lixeira',
                    'all_items' => 'Todos os avisos',
                    'archives' => 'Arquivo de avisos',
                    'attributes' => 'Atributos do aviso',
                    'insert_into_item' => 'Inserir no aviso',
                    'uploaded_to_this_item' => 'Carregado para esse aviso',
                    'featured_image' => 'Imagem destacada',
                    'set_featured_image' => 'Definir imagem destacada',
                    'remove_featured_image' => 'Remover imagem destacada',
                    'use_featured_image' => 'Usar como imagem destacada',
                    'menu_name' => 'Avisos',
                    'filter_items_list' => 'Filtrar lista de avisos',
                    'items_list_navigation' => 'Navegação da lista de avisos',
                    'items_list' => 'Lista de avisos'
                ),
                'public' => true,
                'show_ui' => true,
                'menu_position' => 5,
                'capability_type' => array('aviso', 'avisos'),
                'supports' => array('title', 'editor', 'author', 'revisions'),
                'taxonomies' => array('category'),
                'has_archive' => true,
                'rewrite' => array('slug' => 'aviso'),
                'delete_with_user' => false
            ),
            'editais' => array(
                'labels' => array(
                    'name' => 'Edital',
                    'plural' => 'Editais',
                    'add_new' => 'Adicionar novo',
                    'add_new_item' => 'Adicionar novo edital',
                    'edit_item' => 'Editar edital',
                    'new_item' => 'Novo edital',
                    'view_item' => 'Visualizar edital',
                    'view_items' => 'Visualizar editais',
                    'search_items' => 'Pesquisar editais',
                    'not_found' => 'Nenhum edital foi encontrado',
                    'not_found_in_trash' => 'Nenhum edital foi encontrado na lixeira',
                    'all_items' => 'Todos os editais',
                    'archives' => 'Arquivo de editais',
                    'attributes' => 'Atributos do edital',
                    'insert_into_item' => 'Inserir no edital',
                    'uploaded_to_this_item' => 'Carregado para esse edital',
                    'featured_image' => 'Imagem destacada',
                    'set_featured_image' => 'Definir imagem destacada',
                    'remove_featured_image' => 'Remover imagem destacada',
                    'use_featured_image' => 'Usar como imagem destacada',
                    'menu_name' => 'Editais',
                    'filter_items_list' => 'Filtrar lista de editais',
                    'items_list_navigation' => 'Navegação da lista de editais',
                    'items_list' => 'Lista de editais'
                ),
                'public' => true,
                'show_ui' => true,
                'menu_position' => 5,
                'capability_type' => array('edital', 'editais'),
                'supports' => array('title', 'editor', 'author', 'revisions'),
                'taxonomies' => array('category'),
                'has_archive' => true,
                'rewrite' => array('slug' => 'aviso'),
                'delete_with_user' => false
            ),
        );

        foreach ($tipos as $tipo_key=>$tipo_args){
            register_post_type($tipo_key, $tipo_args);
        }
    }

    /**
    * Remove o botão 'Posts' do menu de administração.
    */
    function removerPostMenuAdmin(){
        remove_menu_page('edit.php');
    }

}

$registradorPosts = new RegistradorPosts();
