<?php
/**
 * Assets Class
 *
 * Handles loading of JavaScript and CSS files
 */

if (!defined('ABSPATH')) {
    exit;
}

class TLW_WooCommerce_Ajax_Search_Assets {
    
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
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }
    
    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts() {
        // Enqueue CSS
        wp_enqueue_style(
            'tlw-woo-ajax-search',
            TLW_WOO_AJAX_SEARCH_PLUGIN_URL . 'assets/css/style.css',
            array(),
            TLW_WOO_AJAX_SEARCH_VERSION
        );
        
        // Enqueue JavaScript
        wp_enqueue_script(
            'tlw-woo-ajax-search',
            TLW_WOO_AJAX_SEARCH_PLUGIN_URL . 'assets/js/search.js',
            array('jquery'),
            TLW_WOO_AJAX_SEARCH_VERSION,
            true
        );
        
        // Localize script with AJAX URL and nonce
        wp_localize_script(
            'tlw-woo-ajax-search',
            'tlwWooAjaxSearch',
            array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce'   => wp_create_nonce('tlw_woo_search_nonce'),
                'strings' => array(
                    'searching'   => __('Searching...', 'tlw-woo-ajax-search'),
                    'noResults'   => __('No products found', 'tlw-woo-ajax-search'),
                    'minChars'    => __('Please enter at least 2 characters', 'tlw-woo-ajax-search'),
                    'error'       => __('An error occurred. Please try again.', 'tlw-woo-ajax-search'),
                )
            )
        );
    }
}
