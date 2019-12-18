<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Woo_Variation_Grid
 * @subpackage Woo_Variation_Grid/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Variation_Grid
 * @subpackage Woo_Variation_Grid/admin
 */
class Woo_Variation_Grid_Admin { 

	/**
	 * The ID of this plugin.
	 *
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 */
	public function enqueue_styles() {

		/**
		 * 
		 * The Woo_Variation_Grid_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 * 
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-variation-grid-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 */
	public function enqueue_scripts() {

		/**
		 * 
		 * The Woo_Variation_Grid_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 * 
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-variation-grid-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Create the section beneath the products tab
	 **/
	public function wvg_add_section( $sections ) {
		
		$sections['woo-variation-grid'] = __( 'Woo Variation Grid', 'woo-variation-grid' );
		return $sections;
		
	}


	/**
	 * Add settings to the specific section that we previously created
	 */
	public function wvg_add_settings( $settings, $current_section ) {

		/**
		 * Check that the current section is indeed what we want
		 **/
		if ( $current_section == 'woo-variation-grid' ) {

			$settings_slider = array();

	 		// Add Title to the Settings
	 		$settings_slider[] = array( 
	 			'name' => __( 'Woo Variation Grid Settings', 'woo-variation-grid' ), 
	 			'type' => 'title', 
	 			'desc' => __( 'The following settings are used to further modify the Woo Variation Grid and to create custom fields for your product variations.', 'woo-variation-grid' ), 
	 			'id' => 'wvg-settings' 
	 		);

			// Add text area to capture custom fields
	 		$settings_slider[] = array(
	 			'name'     		=> __( 'Variable Product Custom Fields', 'woo-variation-grid' ),
	 			'desc_tip' 		=> __( 'Insert any custom fields seperated by a comma that you would like added to your product variations.', 'woo-variation-grid' ),
	 			'description' 	=> __( '(Comma Seperated)', 'woo-variation-grid' ),
	 			'id'       		=> 'wvg-cfs',
	 			'placeholder' 	=> __('field1, field2, ...'),
	 			'type'     		=> 'textarea',
	 		);
			
	 		$settings_slider[] = array( 
	 			'type' => 'sectionend',				
	 			'id' => 'wvg-settings' 
	 		);

	 		return $settings_slider;
		
	 	/**
	 	 * If not, return the standard settings
	 	 **/
	 	} else {
	 		return $settings;
	 	}
	 }

}
