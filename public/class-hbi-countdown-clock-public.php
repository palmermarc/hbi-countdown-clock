<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    HBI_Countdown_Clock
 * @subpackage HBI_Countdown_Clock/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    HBI_Countdown_Clock
 * @subpackage HBI_Countdown_Clock/public
 * @author     Marc Palmer <mapalmer@hbi.com>
 */
class HBI_Countdown_Clock_Public {

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
	 * @var      string    $hbi_countdown_clock       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $hbi_countdown_clock, $version ) {

		$this->hbi_countdown_clock = $hbi_countdown_clock;
		$this->version = $version;
        
        add_shortcode( 'countdown_clock', array( $this, 'display_countdown_clock_shortcode' ) );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in HBI_Countdown_Clock_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The HBI_Countdown_Clock_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		#wp_enqueue_style( $this->hbi_countdown_clock, plugin_dir_url( __FILE__ ) . 'css/hbi-countdown-clock-public.css', array(), $this->version, 'all' );
    	#wp_enqueue_style( 'jquery-flipcountdown', plugin_dir_url( __FILE__ ) . 'css/jquery.flipcountdown.css', array() );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in HBI_Countdown_Clock_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The HBI_Countdown_Clock_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if( is_home() ) :
			#wp_enqueue_script( $this->hbi_countdown_clock, plugin_dir_url( __FILE__ ) . 'js/hbi-countdown-clock-public.js', array( 'jquery', 'jquery-flipcountdown' ), $this->version, false );
        	#wp_enqueue_script( 'jquery-flipcountdown', plugin_dir_url( __FILE__ ) . 'js/jquery.flipcountdown.js', array( 'jquery'    ) );
		endif;
	}
    
    function register_countdown_clock_post_type() {
        $labels = array(
            'name'                => 'Countdown Clocks',
            'singular_name'       => 'Countdown Clock',
            'menu_name'           => 'Countdowns',
            'parent_item_colon'   => 'Parent Countdown Clock:',
            'all_items'           => 'All Countdown Clocks',
            'view_item'           => 'View Countdown Clock',
            'add_new_item'        => 'Add New Countdown Clock',
            'add_new'             => 'Add New',
            'edit_item'           => 'Edit Countdown Clock',
            'update_item'         => 'Update Countdown Clock',
            'search_items'        => 'Search Countdown Clock',
            'not_found'           => 'Not found',
            'not_found_in_trash'  => 'Not found in Trash',
        );
        $args = array(
            'labels'              => $labels,
            'supports'            => array( 'title', ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => true,
            'menu_position'       => 100,
            'menu_icon'           => 'dashicons-clock',
            'register_meta_box_cb' => array( 'HBI_Countdown_Clock_Admin', 'register_countdown_clock_metaboxes' ),
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'capability_type'     => 'page',
        );
        register_post_type( 'countdown', $args );
    }

    public function display_countdown_clock_shortcode( $atts ) {
        // Attributes
        extract( shortcode_atts( array( 'id' => 0, ), $atts ) );
        
        if( 0 == $id ) {
            return;
        }
        if( 'publish' != get_post_status( $id ) ) {
            return;
        }
        
        $clockvars = array(
            'countdown_date_time' => get_post_meta( $id, 'countdown_date_time', TRUE),
            'countdown_use_link' => get_post_meta( $id, 'countdown_use_link', TRUE ),
            'countdown_link_location' => get_post_meta( $id, 'countdown_link_location', TRUE ),
            'mobile_image' => get_post_meta( $id, 'mobile_image', TRUE ),
            'large_mobile_image' => get_post_meta( $id, 'largemobile_image', TRUE ),
            'tablet_image' => get_post_meta( $id, 'tablet_image', TRUE ),
            'desktop_image' => get_post_meta( $id, 'desktop_image', TRUE )
        );
       ?>
        <script>
            var countdown_clock_sizes = <?php echo json_encode( get_option( 'hbi_countdown_clock_sizes' ) ); ?>;
            var countdown_clock_vars = <?php echo json_encode( $clockvars ); ?>;
        </script>
        <style>
            #hbi-countdown-bin {
                height: 130px;
            }
            #hbi-countdown-bin-background { 
                background: #ebebeb url('<?php echo esc_attr( $clockvars['mobile_image'] ); ?>') no-repeat center top; 
                display: block; 
                height: 130px;
                position: relative; 
                width: 100%; 
            }
            #hbi-countdown-clock {
                margin-right: -123px;
                position: absolute;
                right: 50%;
                top: 70px;
                width: 226px
            }
            #countdown-clock-labels {
                color: #fff;
                font-weight: bold;
                text-align: center;
            }
            #countdown-clock-labels td {
                font-size: 10px;
                width: 25%;
            }
            @media (min-width: 480px) {
                #hbi-countdown-bin-background {
                    background-image: url('<?php echo esc_attr( $clockvars['large_mobile_image']); ?>');
                } 
            }
            @media (min-width: 768px) {
                #hbi-countdown-bin {
                    height: 65px;
                }
                #hbi-countdown-bin-background { 
                    background-image: url('<?php echo esc_attr( $clockvars['tablet_image']); ?>'); 
                    height: 65px; 
                }
                #hbi-countdown-clock {
                    margin-right: 30px;
                    position: absolute;
                    right: 0;
                    top: 3px;
                }
            }
            @media (min-width: 985px) {
                #hbi-countdown-bin-background { 
                    background-image: url('<?php echo esc_attr( $clockvars['desktop_image']); ?>'); 
                }
            }
        </style>
        <div id="hbi-countdown-bin">
            <a id="hbi-countdown-bin-background" href="<?php echo esc_attr( $clockvars['countdown_link_location'] ); ?>">&nbsp;</a>
            <div id="hbi-countdown-clock">
                <table>
                    <tr>
                        <td colspan="4"><span id="countdown-clock"></span></td>
                    </tr>
                    <tr id="countdown-clock-labels">
                        <td>Days</td>
                        <td>Hours</td>
                        <td>Minutes</td>
                        <td>Seconds</td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
    }
}
