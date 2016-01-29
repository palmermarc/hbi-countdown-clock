<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://hubbardinteractivestl.com
 * @since      1.0.0
 *
 * @package    HBI_Countdown_Clock
 * @subpackage HBI_Countdown_Clock/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    HBI_Countdown_Clock
 * @subpackage HBI_Countdown_Clock/admin
 * @author     Marc Palmer <mapalmer@hbi.com>
 */
class HBI_Countdown_Clock_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $hbi_countdown_clock    The ID of this plugin.
	 */
	private $hbi_countdown_clock;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $hbi_countdown_clock       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $hbi_countdown_clock, $version ) {
		$this->hbi_countdown_clock = $hbi_countdown_clock;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
        $screen = get_current_screen();
        
        if( ( 'countdown_page_hbi_countdown_clock' == $screen->base || 'post' == $screen->base ) && 'countdown' == $screen->post_type ) {
            wp_enqueue_style( $this->hbi_countdown_clock, plugin_dir_url( __FILE__ ) . 'css/hbi-countdown-clock-admin.css', array(), $this->version, 'all' );
        }
	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
	    
        $screen = get_current_screen();
        if( ( 'countdown_page_hbi_countdown_clock' == $screen->base || 'post' == $screen->base ) && 'countdown' == $screen->post_type ) {
            wp_enqueue_script( $this->hbi_countdown_clock, plugin_dir_url( __FILE__ ) . 'js/hbi-countdown-clock-admin.js', array( 'jquery', 'jquery-ui-datepicker' ) );
        }
	}
    
    
    /**
     * Adds the Countdown Clock Settings Page as a Submenu Page
     * 
     * @since 1.0.0 
     */
    public function add_countdown_settings_submenu_page() {
        add_submenu_page( 'edit.php?post_type=countdown', 'HBI Countdown Clock Settings', 'Settings', 'manage_options', 'hbi_countdown_clock', array( $this, 'hbi_countdown_clock_settings_page' ) );
    }
    
    /**
     * Display the settings page
     * 
     * @since 1.0.0
     */
     public function hbi_countdown_clock_settings_page() {
        include_once plugin_dir_path( __FILE__ ) . 'partials/hbi-countdown-clock-admin-display.php';

     }
    
    /**
     * Register the settings fields used for the plugin
     * 
     * @since 1.0.0
     */
    public function register_hbi_countdown_clock_settings() {
        
        register_setting( 
            'hbi_countdown_clock_settings', // Option Group 
            'hbi_countdown_clock_sizes',    // Option Name
            array( $this, 'sanitize_hbi_countdown_clock_settings' ) // Sanitize Function
        );
        
        add_settings_section(
            'hbi_countdown_click_size_settings',             // id attribute
            'HBI Countdown Clock Settings',             // Title
            null,   // Callback Function
            'hbi_countdown_clock'              // Page
        );
        
        add_settings_field( 
            'hbi-countdown-clock-sizes',                            // ID
            null,                                                // Title
            array( $this, 'hbi_countdown_clock_sizes_setting' ),    // Calback Function 
            'hbi_countdown_clock',                         // Page
            'hbi_countdown_click_size_settings'                          // Section
        );
        //add_settings_field( $id, $title, $callback, $page, $section, $args );
    }
    
    public function hbi_countdown_clock_sizes_setting() {
        $sizes = get_option('hbi_countdown_clock_sizes');
        $count = 1; 
        ?>
        <table id="countdown_sizes" cellpadding="0" cellspacing="0" border="0">
            <thead>
                <tr>
                    <th style="text-align: center;">Name</th>
                    <th style="text-align: center;">Width</th>
                    <th style="text-align: center;">Height</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
             <?php if( !empty( $sizes ) ) : ?>
                <?php foreach( $sizes as $size ) : ?>
                    <tr>
                        <td><input type="text" name="hbi_countdown_clock_sizes[sizes][<?php echo $count; ?>][name]" value="<?php echo $size['name']; ?>" /></td>
                        <td><input type="text" name="hbi_countdown_clock_sizes[sizes][<?php echo $count; ?>][width]" value="<?php echo $size['width']; ?>" /></td>
                        <td><input type="text" name="hbi_countdown_clock_sizes[sizes][<?php echo $count; ?>][height]" value="<?php echo $size['height']; ?>" /></td>
                        <td class="remove_image_size">Remove Image Size</td>
                    </tr>
                    <?php $count++;
                endforeach;
            endif; ?>
            </tbody>
        </table>
        
        <p id="add_another_row">Add Another Countdown Size</p>
        
        <template id="countdown_clock_size_template">
            <tr>
                <td><input class="size_name" type="text" name="name" value="" /></td>
                <td><input class="size_width" type="text" name="width" value="" /></td>
                <td><input class="size_height" type="text" name="height" value="" /></td>
                <td class="remove_image_size">Remove Image Size</td>
            </tr>
        </template>
        <?php
    }
    
    function sanitize_hbi_countdown_clock_settings( $input ) {
        $new_input = array();
        
        if( !empty( $input['sizes'] ) ) :
            foreach( $input['sizes'] as $key => $size ) :
                $image_size['name'] = sanitize_text_field( $size['name'] );
                $image_size['width'] = sanitize_text_field( $size['width'] );
                $image_size['height'] = sanitize_text_field( $size['height'] );
                if( !empty( $size['name'] ) )
                    $new_input[] = $image_size;
            endforeach;
        endif;
        
        return $new_input;
    }
    
    public function register_countdown_clock_metaboxes() {
        add_meta_box( 'hbi_countdown_clock', 'Countdown Clock Details', array( 'HBI_Countdown_Clock_Admin', 'hbi_countdown_clock_metabox' ), 'countdown' );
    }
    
    public function hbi_countdown_clock_metabox( $object ) {
        wp_nonce_field( 'hbi_countdown_nonce', 'countdown_sec' );
        
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/hbi-countdown-clock-metabox.php';
    }

    /**
     * Saves the Countdown metabox on Publish/Update
     * 
     * @since 1.0.0
     */
    public function save_countdown_metabox( $post_id ) {
        // Not even the right post_type. Dip set.
        if( 'countdown' != $_POST['post_type'] ) {
            return;
        }
            
        // Failed a basic security check. Dip set.
        if ( ! isset( $_POST['countdown_sec'] ) || ! wp_verify_nonce( $_POST['countdown_sec'], 'hbi_countdown_nonce' ) ) {
            return;
        }
        
        $sizes = get_option( 'hbi_countdown_clock_sizes' );

        if( !empty( $sizes ) ) :
            foreach( $sizes as $size ) :
                $field_name = strtolower( $size['name'] . '_image' );
                $field_value = ( isset( $_POST[$field_name] ) ) ? $_POST[$field_name] : '';
                update_post_meta( $post_id, $field_name, $field_value );
            endforeach;
        endif;
        
        update_post_meta( $post_id, 'countdown_date_time', $_POST['countdown_date_time'] );
        update_post_meta( $post_id, 'countdown_use_link', $_POST['countdown_use_link'] );
        update_post_meta( $post_id, 'countdown_link_location', $_POST['countdown_link_location'] );
    }
}