<?php
/**
 * Shortcode Class
 *
 * Handles the [tlw_woo_search] shortcode
 */

if (!defined('ABSPATH')) {
    exit;
}

class TLW_WooCommerce_Ajax_Search_Shortcode {
    
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
        add_shortcode('tlw_woo_search', array($this, 'render_search_form'));
    }
    
    /**
     * Render the search form
     *
     * @param array $atts Shortcode attributes
     * @return string
     */
    public function render_search_form($atts) {
        $atts = shortcode_atts(array(
            'placeholder' => __('Search products...', 'tlw-woo-ajax-search'),
            'button_text' => __('Search', 'tlw-woo-ajax-search'),
            'show_button' => 'no',
        ), $atts, 'tlw_woo_search');
        
        ob_start();
        ?>
        <div class="tlw-woo-search-container">
            <form class="tlw-woo-search-form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <div class="tlw-woo-search-input-wrapper">
                    <input 
                        type="text" 
                        class="tlw-woo-search-input" 
                        name="s"
                        placeholder="<?php echo esc_attr($atts['placeholder']); ?>"
                        autocomplete="off"
                        aria-label="<?php esc_attr_e('Search products', 'tlw-woo-ajax-search'); ?>"
                    >
                    <span class="tlw-woo-search-icon">
                        <span class="dashicons dashicons-search"></span>
                    </span>
                </div>
                <?php if ($atts['show_button'] === 'yes') : ?>
                    <button type="submit" class="tlw-woo-search-button">
                        <?php echo esc_html($atts['button_text']); ?>
                    </button>
                <?php endif; ?>
                <input type="hidden" name="post_type" value="product">
            </form>
            <div class="tlw-woo-search-results" aria-live="polite"></div>
        </div>
        <?php
        return ob_get_clean();
    }
}
