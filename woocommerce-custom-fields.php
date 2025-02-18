<?php /* 
Plugin Name: Woocommerce Custom Fields
description: Create Custom fields as Length,Width and Weight for Product Detail page in Woo Commerce
version: 1.0
author: Pritesh Rajpura
*/

// Display custom fields in the "General" tab of the product edit page
add_action('woocommerce_product_options_general_product_data', 'add_custom_product_fields');

function add_custom_product_fields()
{
    global $product_object;

    echo '<div class="product_custom_fields">';

    echo '<h3 style="margin-left:11px">Additional Custom Fields</h3>';

    // Text field
    woocommerce_wp_text_input(
        array(
            'id' => '_custom_field_length_text',
            'label' => __('Length', 'woocommerce'),
            'placeholder' => '',
            'desc_tip' => 'true',
            'description' => __('Enter Length of Product', 'woocommerce')
        )
    );

    woocommerce_wp_text_input(
        array(
            'id' => '_custom_field_width_text',
            'label' => __('Width', 'woocommerce'),
            'placeholder' => '',
            'desc_tip' => 'true',
            'description' => __('Enter Width of Product', 'woocommerce')
        )
    );

    woocommerce_wp_text_input(
        array(
            'id' => '_custom_field_height_text',
            'label' => __('Height', 'woocommerce'),
            'placeholder' => '',
            'desc_tip' => 'true',
            'description' => __('Enter Height of Product.', 'woocommerce')
        )
    );

    echo '</div>';
}

// Save custom fields when the product is saved
add_action('woocommerce_process_product_meta', 'save_custom_product_fields');

function save_custom_product_fields($product_id)
{
    // Save text field
    $custom_length_field_text = isset($_POST['_custom_field_length_text']) ? sanitize_text_field($_POST['_custom_field_length_text']) : '';
    update_post_meta($product_id, '_custom_field_length_text', $custom_length_field_text);

    // Save select field
    $custom_width_field_select = isset($_POST['_custom_field_width_text']) ? sanitize_text_field($_POST['_custom_field_width_text']) : '';
    update_post_meta($product_id, '_custom_field_width_text', $custom_width_field_select);

    // Save select field
    $custom_height_field_select = isset($_POST['_custom_field_height_text']) ? sanitize_text_field($_POST['_custom_field_height_text']) : '';
    update_post_meta($product_id, '_custom_field_height_text', $custom_height_field_select);
}

add_filter('woocommerce_before_add_to_cart_form','add_text_in_product_detail');
function add_text_in_product_detail(){
   if(is_product()){
       $length = get_post_meta(get_the_ID(),'_custom_field_length_text',true);
       $width = get_post_meta(get_the_ID(),'_custom_field_width_text',true);
       $height = get_post_meta(get_the_ID(),'_custom_field_height_text',true);

       echo 'Dimentions '.$width.' X '.$height.' X '.$length;
   }
}