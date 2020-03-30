<?php
/**
 * Remove WP version number throughout site
 *
 * @package     KayMozCeramics
 * @subpackage  KayMozCeramics/includes
 * @copyright   Copyright (c) 2014, Jason Witt
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 * @author      Jason Witt <contact@jawittdesigns.com>
 */
class KayMozCeramics_Remove_WP_Version {
	/**
	 * Initialize the class
	 */
	public function __construct() {
		// add_filter( 'style_loader_src', 'kmc_remove_wp_version_from_style_js' );
		// add_filter( 'script_loader_src', array( $this, 'kmc_remove_wp_version_from_style_js' ) );
	}
	/**
     * Remove WP generated content from the head
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
	public function kmc_remove_wp_version_from_style_js() {
		if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
		$src = remove_query_arg( 'ver', $src );
		return $src;
	}
}