<?php
/**
 * Plugin Name: TLW WooCommerce AJAX Search
 * Plugin URI: https://talaweb.hu
 * Description: A powerful AJAX-powered search plugin for WooCommerce products with real-time results
 * Version: 1.0.0
 * Author: TalaWeb
 * Author URI: https://talaweb.hu
 * Text Domain: tlw-woo-ajax-search
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * WC requires at least: 5.0
 * WC tested up to: 8.0
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin constants
define('TLW_WOO_AJAX_SEARCH_VERSION', '1.0.0');
define('TLW_WOO_AJAX_SEARCH_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('TLW_WOO_AJAX_SEARCH_PLUGIN_URL', plugin_dir_url(__FILE__));
define('TLW_WOO_AJAX_SEARCH_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Check if WooCommerce is active
 */
function tlw_woo_ajax_search_check_woocommerce() {
    if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        add_action('admin_notices', 'tlw_woo_ajax_search_woocommerce_missing_notice');
        deactivate_plugins(TLW_WOO_AJAX_SEARCH_PLUGIN_BASENAME);
        return false;
    }
    return true;
}

/**
 * Display admin notice if WooCommerce is not active
 */
function tlw_woo_ajax_search_woocommerce_missing_notice() {
    ?>
    <div class="error">
        <p><?php _e('TLW WooCommerce AJAX Search requires WooCommerce to be installed and active.', 'tlw-woo-ajax-search'); ?></p>
    </div>
    <?php
}

/**
 * Initialize the plugin
 */
function tlw_woo_ajax_search_init() {
    if (!tlw_woo_ajax_search_check_woocommerce()) {
        return;
    }

    // Load plugin text domain
    load_plugin_textdomain('tlw-woo-ajax-search', false, dirname(TLW_WOO_AJAX_SEARCH_PLUGIN_BASENAME) . '/languages');

    // Include required files
    require_once TLW_WOO_AJAX_SEARCH_PLUGIN_DIR . 'includes/class-ajax-handler.php';
    require_once TLW_WOO_AJAX_SEARCH_PLUGIN_DIR . 'includes/class-shortcode.php';
    require_once TLW_WOO_AJAX_SEARCH_PLUGIN_DIR . 'includes/class-assets.php';

    // Initialize classes
    TLW_WooCommerce_Ajax_Search_Handler::get_instance();
    TLW_WooCommerce_Ajax_Search_Shortcode::get_instance();
    TLW_WooCommerce_Ajax_Search_Assets::get_instance();
}

add_action('plugins_loaded', 'tlw_woo_ajax_search_init');

/**
 * Activation hook
 */
function tlw_woo_ajax_search_activate() {
    if (!tlw_woo_ajax_search_check_woocommerce()) {
        wp_die(__('Please install and activate WooCommerce before activating TLW WooCommerce AJAX Search.', 'tlw-woo-ajax-search'));
    }
}

register_activation_hook(__FILE__, 'tlw_woo_ajax_search_activate');
