<?php
/*
    Plugin Name: SlideJS Plugin
    Description: SlideJS WordPress plugin.
    Author: kukac7
    Version: 1.0
*/

function sp_init() {
    $args = array(
        'public' => true,
        'label' => 'Slider',
        'supports' => array(
        	'title',
            'editor',
            'thumbnail'
        )
    );
    register_post_type('sp_images', $args);
}
 
add_action('init', 'sp_init'); 

function sp_register_scripts() {
    if (!is_admin()) {
        wp_register_script('sp_slides_js', plugins_url('js/jquery.slides.min.js', __FILE__), array('jquery') );
        wp_register_script('sp_script', plugins_url('js/script.js', __FILE__), array('jquery') );
 
        wp_enqueue_script('sp_slides_js');
        wp_enqueue_script('sp_script');
    }
}
 
add_action('wp_print_scripts', 'sp_register_scripts');

add_image_size('sp_function', 600, 280, true);

function display_sp_slider() {
 
    // We only want posts of the testimonials type
    $args = array(
        'post_type' => 'sp_images',
        'posts_per_page' => 5
    );
 
    // We create our html in the result variable
    $result .='<div id="slides">';
 
    $the_query = new WP_Query($args);
 
    // Creating a new side loop
    while ( $the_query->have_posts() ) : $the_query->the_post();
          
          	$result .='<div class="slide">';
            // Displaying the content
            $the_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $type);
            if ($the_url != '') {
            $result .='<img title="'.get_the_title().'" src="' . $the_url[0] . '" data-thumb="' . $the_url[0] . '" alt=""/><div class="caption">'.get_the_content().'</div>';
            }
            else {
            $result .='<div class="caption">'.get_the_content().'</div>';
            }
            $result .='</div>';
     
    endwhile;    
 
    $result .= '</div>';
 
    return $result;
}

add_shortcode('slides-slider', 'display_sp_slider');

function sp_help( $contextual_help, $screen_id, $screen ) { 
	if ( 'sp_images' == $screen->id ) {

		$contextual_help = '<h2>Képek mérete</h2>
		<p>960px * 335px</p>';

	}
	return $contextual_help;
}

add_action( 'contextual_help', 'sp_help', 10, 3 );

//function posts_columns($defaults){
//    $defaults['post_thumbs'] = __('Thumbs');
//    return $defaults;
//}
//function posts_custom_columns($column_name, $id){
//        if($column_name === 'post_thumbs'){
//        echo the_post_thumbnail( 'featured_thumbnail' );
//    }
//}
//
//add_filter('manage_posts_columns', 'posts_columns', 5);
//add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);

?>