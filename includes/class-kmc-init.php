<?php
/**
 * Main Init Class
 *
 * @package     KayMozCeramics
 * @subpackage  KayMozCeramics-functionality/includes
 * @copyright   Copyright (c) 2014, Jason Witt
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 * @author      Jason Witt <contact@jawittdesigns.com>
 */
class KayMozCeramics_Init {
	/**
	 * Initialize the class
	 */
	public function __construct() {
		$add_admin_stuff		 	 = new KayMozCeramics_Admin();
		$kmc_woocommerce_functions	 = new KayMozCeramics_WooCommerce();
		$kmc_sharing				 = new KayMozCeramics_Sharing();
		$register_post_types     	 = new KayMozCeramics_Register_Post_Types();
		$register_taxonomies     	 = new KayMozCeramics_Register_Taxonomies();
		$remove_admin_bar 	     	 = new KayMozCeramics_Remove_Admin_Bar();
		$clean_up_head		     	 = new KayMozCeramics_Clean_Up_Head();
		$insert_figure		     	 = new KayMozCeramics_Insert_Figure();
		$long_url_spam		     	 = new KayMozCeramics_Long_URL_Spam();
		$remove_jetpack_bar      	 = new KayMozCeramics_Remove_Jetpack_Bar();
		$remove_assets			 	 = new KayMozCeramics_Remove_Unwated_Assets();
		$remove_post_author_url  	 = new KayMozCeramics_Remove_Post_Author_Url();
		$remove_wp_version			 = new KayMozCeramics_Remove_WP_Version();
		
	}
}