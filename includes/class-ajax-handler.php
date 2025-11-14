<?php
/**
 * AJAX Handler Class
 *
 * Handles all AJAX requests for product search
 */

if (!defined('ABSPATH')) {
    exit;
}

class TLW_WooCommerce_Ajax_Search_Handler {
    
    private static $instance = null;
    
    /**
     * Get singleton instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        // AJAX hooks for logged in and non-logged in users
        add_action('wp_ajax_tlw_woo_search', array($this, 'handle_search'));
        add_action('wp_ajax_nopriv_tlw_woo_search', array($this, 'handle_search'));
    }
    
    /**
     * Handle AJAX search request
     */
    public function handle_search() {
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'tlw_woo_search_nonce')) {
            wp_send_json_error(array('message' => __('Security check failed', 'tlw-woo-ajax-search')));
        }
        
        // Get search query
        $search_query = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';
        
        if (empty($search_query) || strlen($search_query) < 2) {
            wp_send_json_error(array('message' => __('Please enter at least 2 characters', 'tlw-woo-ajax-search')));
        }
        
        // Get products
        $products = $this->search_products($search_query);
        
        if (empty($products)) {
            wp_send_json_success(array(
                'products' => array(),
                'message' => __('No products found', 'tlw-woo-ajax-search')
            ));
        }
        
        wp_send_json_success(array('products' => $products));
    }
    
    /**
     * Search for products
     *
     * @param string $search_query
     * @return array
     */
    private function search_products($search_query) {
        $args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => 10,
            's'              => $search_query,
            'orderby'        => 'relevance',
            'order'          => 'DESC',
        );
        
        // Apply WooCommerce product visibility
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => array('exclude-from-search', 'exclude-from-catalog'),
                'operator' => 'NOT IN',
            ),
        );
        
        $query = new WP_Query($args);
        $products = array();
        
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $product = wc_get_product(get_the_ID());
                
                if (!$product) {
                    continue;
                }
                
                // Get product image
                $image_id = $product->get_image_id();
                $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'thumbnail') : wc_placeholder_img_src('thumbnail');
                
                // Get price HTML
                $price_html = $product->get_price_html();
                
                // Get stock status
                $in_stock = $product->is_in_stock();
                $stock_status = $in_stock ? __('In stock', 'tlw-woo-ajax-search') : __('Out of stock', 'tlw-woo-ajax-search');
                
                $products[] = array(
                    'id'           => $product->get_id(),
                    'title'        => $product->get_name(),
                    'url'          => get_permalink($product->get_id()),
                    'image'        => $image_url,
                    'price'        => $price_html,
                    'in_stock'     => $in_stock,
                    'stock_status' => $stock_status,
                    'sku'          => $product->get_sku(),
                    'excerpt'      => wp_trim_words($product->get_short_description(), 15),
                );
            }
            wp_reset_postdata();
        }
        
        return $products;
    }
}
