<?php
require(WP_CONTENT_DIR . "/themes/ifc-v2/functions-shared.php");

function achar_parte_em_dominio($parte, $dominio){
    return in_array($parte, explode('.', $dominio));
}

function achar_site_em_network($parte_dominio, $network_id){
    $sites = get_sites(array(
        'network_id' => $network_id
    ));
    foreach ($sites as $site){
        if (achar_parte_em_dominio($parte_dominio, $site->domain)){
            return $site;
        }
    }
    return null;
}

function get_global_noticias_site(){
    return achar_site_em_network("noticias", 0);
}

function get_local_noticias_site(){
    return achar_site_em_network("noticias", get_network()->id);
}

function query_noticias_mistas(){
    $id_local_noticias_site = get_local_noticias_site()->blog_id;
    $id_global_noticias_site = get_global_noticias_site()->blog_id;
    
    switch_to_blog($id_local_noticias_site);
    $query_local = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => 10
    ));
    foreach ($query_local->posts as $post) {
        $post->blog_id = $id_local_noticias_site;
    }
    restore_current_blog();
    
    switch_to_blog($id_global_noticias_site);
    $query_global = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => 10,
        'meta_query' => array(
            array(
                'key' => 'propagacao_campi',
                'compare' => '==',
                'value' => 1
            )
        )
    ));

    foreach ($query_global->posts as $post) {
        $post->blog_id = $id_global_noticias_site;
    }
    restore_current_blog();

    $query = new WP_Query();
    $query->posts = wp_list_sort(array_merge($query_local->posts, $query_global->posts), 'post_date', 'DESC');
    $query->post_count = $query_local->post_count + $query_global->post_count;

    return $query;
}

wp_enqueue_style('estilo campi' , get_stylesheet_uri() );