<?php 
/**
* Plugin Name: Sedoo Doc Manager
* Plugin URI : https://github.com/sedoo/sedoo-wppl-docmanager
* Description: Plugin pour gérer des documents
* Author: Pierre VERT & Nicolas Gruwe
* Version: 0.1.2
* GitHub Plugin URI: sedoo/sedoo-wppl-docmanager
* GitHub Branch:     master
*/

include 'inc/commons.php';

function sedoo_docmanager_plugin_init(){

    /* Gestion de la dépendance de ACF */
	if ( ! function_exists('get_field') && current_user_can( 'activate_plugins' ) ) {
        
        add_action( 'admin_init', 'sb_plugin_deactivate');
        add_action( 'admin_notices', 'sb_plugin_admin_notice');

        //Désactiver le plugin
        function sb_plugin_deactivate () {
            deactivate_plugins( plugin_basename( __FILE__ ) );
        }
        
        // Alerter pour expliquer pourquoi il ne s'est pas activé
        function sb_plugin_admin_notice () {
            
            echo '<div class="error">Le plugin "Slider Button" requiert ACF Pro pour fonctionner <br><strong>Activez ACF Pro ci-dessous</strong> ou <a href=https://wordpress.org/plugins/advanced-custom-fields/> Téléchargez ACF Pro &raquo;</a><br></div>';

            if ( isset( $_GET['activate'] ) ) 
                unset( $_GET['activate'] );	
        }

    } else {
    // Le plugin est activé 

    require_once 'inc/acf-config.php';
        /** 
        * Création du custom post type (cpt)
        */
        add_action('init', 'sedoo_docmanager_cpt');
        function sedoo_docmanager_cpt() {
            register_post_type( 
                'sedoo-document', 							
                array(
                    'label' => 'Documents', 			
                    'labels' => array(    			
                        'name' => 'Documents',
                        'singular-name' => 'Document',
                        'all_items' => 'Tous les documents',
                        'add_new_item' => 'Ajouter un document',
                        'edit_item' => 'Editer le document',
                        'new_item' => 'Nouveau document',
                        'view_item' => 'Voir le document',
                        'search_item' => 'Rechercher parmis les documents',
                        'not_found' => 'Pas de document trouvé',
                        'not_found_in_trash' => 'Pas de document dans la corbeille'
                    ),
                    'public' => true, 				
                    'show_in_rest' => true,         
                    'capability_type' => 'post',	
                    'supports' => array(			
                        'title',
                        // 'author',
                        'editor'	
                    ),
                    'has_archive' => true, 
                    // Url vers une icone ou à choisir parmi celles de WP : https://developer.wordpress.org/resource/dashicons/.
                    'menu_icon'   => 'dashicons-media-document'
                ) 
            );
        }

        /******************************************************************
        * CUSTOM TAXONOMIES 
        */

        add_action('init', 'sedoo_docmanager_taxonomies');
        function sedoo_docmanager_taxonomies()
        {
            
            /*** 
            *  TAXONOMIE TYPE DE DOCUMENTS
            */
            
            $labels_type = array(
                'name' => 'Types de document',
                'singular_name' => 'Type',
                'all_items' => 'Toutes les types de document',
                'edit_item' => 'Éditer le type de document',
                'view_item' => 'Voir le type de document',
                'update_item' => 'Mettre à jour le type de document',
                'add_new_item' => 'Ajouter un type de document',
                'new_item_name' => 'Nouveau type de document',
                'search_items' => 'Rechercher parmi les types de document',
                'popular_items' => 'Types de document les plus utilisées',
            );
            
            $args_type = array (
                'label' => 'Type de document',
                'labels' => $labels_type,
                'hierarchical' => true,
        //        'show_admin_column' => false,
        //        'show_in_nav_menus' => false,
        //        'show_tagcloud' => false,
                'show_ui' => true,
                'show_in_rest' => true
            );

            register_taxonomy('sedoo-type-document', array('sedoo-document'), $args_type);

            register_taxonomy_for_object_type( 'sedoo-type-document', 'document' );
        }

        /*
        * REGISTER TPL SINGLE
        */
        add_filter ( 'single_template', 'sedoo_docmanager_single' );
        function sedoo_docmanager_single($single_template) {
            global $post;
            
            if ($post->post_type == 'sedoo-document') {
                $single_template = plugin_dir_path ( __FILE__ ) . 'single-sedoo-document.php';
            }
            return $single_template;
        }
        

        /*
        * REGISTER TPL SINGLE
        */
        add_filter ( 'template_include', 'sedoo_docmanager_taxonomy' ); 
        function sedoo_docmanager_taxonomy($taxonomy_template) {
            global $post;
            
            if ( is_tax( 'sedoo-type-document' ) ) {
                $taxonomy_template = plugin_dir_path ( __FILE__ ) . 'taxonomy-sedoo-type-document.php';
            }
            return $taxonomy_template;
        }
    
    } // end test plugin ACF

}
add_action('plugins_loaded', 'sedoo_docmanager_plugin_init');
?>