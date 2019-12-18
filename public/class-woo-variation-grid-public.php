<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Woo_Variation_Grid
 * @subpackage Woo_Variation_Grid/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woo_Variation_Grid
 * @subpackage Woo_Variation_Grid/public
 */

class Woo_Variation_Grid_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		// Add the shortcode variation output shortcode
		add_shortcode( 'woo_variation_grid', array($this, 'wvg_variations_output_shortcode' ));

		// Grid and table display functions
		require_once dirname( __FILE__ ) . '/partials/woo-variation-grid-public-display.php';

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 */
	public function enqueue_styles() {

		/**
		 * 
		 * The Woo_Variation_Grid_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 * 
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-variation-grid-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'dataTables-css', '//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css', array(), $this->version);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 */
	public function enqueue_scripts() {

		/**
		 *
		 * The Woo_Variation_Grid_Loader will create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 * 
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-variation-grid-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'dataTables-js', '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js', array( 'jquery' ), $this->version, false );
	}

    
    /**
     * Shortcode outputs a grid or table of product variations
     * 
     */
    public function wvg_variations_output_shortcode( $atts ) {

		/**
		 * Get the current page
		 */
		$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
		
		
		/**
		 *  Merge user specified attributes with default shortcode attribute values
		 */
		$wvg_atts = shortcode_atts( 
			array(
				'display'   => 'grid',  									// Grid / Table
				'heading'	=> '',											// Heading / Title - If Any
				'parent'	=> '',											// Parent Product ID
				'limit'     => '12',     									// Amount of products to display per page
				'thead'		=> 'Image, Name, Sku, Price, Add to cart', 		// Default Table headings - Changing the order will be reflected in the table
				'order'		=> 'DESC',									 	// Accepts a string: 'DESC' or 'ASC'. Use with 'orderby'.
				'orderby'	=> 'modified',									// Accepts a string: 'none', 'ID', 'name', 'type', 'rand', 'date', 'modified'.
				'cf_filter' => ''											// Filter out specific product variations with an equal custom field value -- Format: `key:value`
			), $atts
		);


		/**
		 * Product variation arguments used in querying products of type 'variation'
		 */
		$variation_args = array(
			'type' 		=> 'variation',
			'parent' 	=> $wvg_atts['parent'],
			'limit' 	=> $wvg_atts['limit'],
			'order'		=> $wvg_atts['order'],
			'orderby' 	=> $wvg_atts['orderby'],
			'paginate' 	=> true,
			'page'		=> $paged,
		);


		/**
		 * Check if user has specified a custom field `key:value` pair
		 */
		if ($wvg_atts['cf_filter'] !== '' && strpos($wvg_atts['cf_filter'], ':') !== false) {

			$parameters = explode(':', trim($wvg_atts['cf_filter'])); 	// Break string into usable parameters
			$key = $parameters[0]; 										// Custom Field Key
			$value = $parameters[1];									// Custom Field Value

			/*
			* Dynamically add custom parameter support to wc_get_product query
			*/
			add_filter( 'woocommerce_product_data_store_cpt_get_products_query', function( $query, $query_vars ) use(&$key, &$value) {
				
				if ( ! empty( $query_vars[$key] ) ) {
					$query['meta_query'][] = array(
						'key' => $key,
						'value' => esc_attr( $value ),
					);
				}

				return $query;
				
			}, 10, 2 );

			$variation_args[$key] = $value; // Add argument to query
		}


		/**
		 * Fetch our product variations using the custom arguments provided via the shortcode atts array
		 */
		$variations = wc_get_products( $variation_args );


		/*
		 * Array containing (options / data) that is passed to the layout function
		 */
		$data = array(
			"heading" => $wvg_atts['heading'], // Title / Heading if specified
			"limit" => $wvg_atts['limit'],
			"thead" => array_map('trim', array_map('strtolower', explode(',', $wvg_atts['thead']))) // Cleaned th headings
		);


		/**
		 * Use table layout if specified
		 */
		if ( $wvg_atts['display'] === 'table' && !empty($wvg_atts['thead'])) {

			// Return the table view html
			return wvg_table_output($variations, $data);

		}

		/**
		 * Otherwise use the default grid view
		 */
		return wvg_grid_output($variations, $data);

	}

}
