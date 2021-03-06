<?
/*
Plugin Name: CF7 basket
Description: Simple baskety of product based on CF7 form
Version: 1.2
Author: Senquiem
*/

define('MSP_HELLOWORLD_DIR', plugin_dir_path(__FILE__));
define('MSP_HELLOWORLD_URL', plugin_dir_url(__FILE__));

add_action( 'admin_menu', 'my_plugin_menu' );

// lib to generate pdf from email html
include( plugin_dir_path( __FILE__ ) . 'includes/dompdf/autoload.inc.php');

###
# style sheet function
###

function productCartFromCF7_css() {

wp_register_style('productCartFromCF7', plugins_url('/css/productCartFromCF7.css',__FILE__ ));
wp_enqueue_style('productCartFromCF7');

wp_register_style('CF7fields', plugins_url('/css/CF7fields.css',__FILE__ ));
wp_enqueue_style('CF7fields');

wp_register_script( 'CF7fields_control', plugins_url ('/js/CF7fields_control.js',__FILE__ ), array(), '1.2', false );
    wp_enqueue_script( 'CF7fields_control' );
}
add_action( 'wp_head','productCartFromCF7_css');

//$cate = get_queried_object();
//$cateID = $cate->term_id;

###
# display exist list of products
###
function get_product_list() {
/**
if You haven't category object, please use this request
$catData = current_category_data($post->ID);
*/
$catData = current_category_data($post->ID);

?>


<script type="text/javascript">

    var vallo_ready_cartus = <?php echo json_encode($_COOKIE['vallo_cf7_cartus_3']); ?>;
    var produc_CF7_image = '<?php  
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'single-post-thumbnail' );
    echo $image[0]; ?>';
    var produc_CF7_title = '<?php      
    wp_title(''); ?>';
    var produc_CF7_category = '<?php      
    echo $catData->term_id; ?>';
</script>
<script type='text/javascript' src='<?php echo plugins_url('/js/get_product_list.js?ver=1.9',__FILE__ ) ?>'></script>
<?php
// add new products to basket
?><script type='text/javascript' src='<?php echo plugins_url('/js/add_to_product_list.js?ver=2.1',__FILE__ ) ?>'></script>
<script type='text/javascript' src='<?php echo plugins_url('/js/add_to_product_activation.js?ver=1.2',__FILE__ ) ?>'></script>
<?php


###
# end of base function
###
}
add_action( 'wp_footer','get_product_list');



###
# add buttom "add to cart" function
###

function add_CF7_basket_buttom(){
global $post;
    $buttom_container = '<div class="add_to_cart_container">
<input type="number" class="number_to_cart" step="500" value="500" min="500" />
<a data-serv-id="'. $post->ID . '" class="adding_to_cart">Add to request</a>
</div>';
echo $buttom_container;
}
add_action('add_CF7_basket_buttom', 'add_CF7_basket_buttom');

