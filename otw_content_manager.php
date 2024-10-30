<?php
/**
Plugin Name: Content Manager Light
Plugin URI: http://OTWthemes.com
Description:  Build your custom page layout and fill it with ready to use widets/content. Easy, no coding. 
Author: OTWthemes
Version: 3.2
Author URI: https://codecanyon.net/user/otwthemes/portfolio?ref=OTWthemes
*/

load_plugin_textdomain('otw_lcm',false,dirname(plugin_basename(__FILE__)) . '/languages/');

$wp_cm_tmc_items = array(
	'page'              => array( array(), esc_html__( 'Pages', 'otw_lcm' ) ),
	'post'              => array( array(), esc_html__( 'Posts', 'otw_lcm' ) )
);

$wp_cm_agm_items = array(
	'page'              => array( array(), esc_html__( 'Pages', 'otw_lcm' ) ),
	'post'              => array( array(), esc_html__( 'Posts', 'otw_lcm' ) )
);

$wp_cm_cs_items = array(
	'page'              => array( array(), esc_html__( 'Pages', 'otw_lcm' ) ),
	'post'              => array( array(), esc_html__( 'Posts', 'otw_lcm' ) )
);

$otw_lcm_skins = array(

);

$otw_lcm_plugin_id = '0b05968e5a4bcae773a24ec3afe77be4';

$otw_lcm_plugin_url = plugins_url( substr( dirname( __FILE__ ), strlen( dirname( dirname( __FILE__ ) ) ) ) );
$otw_lcm_css_version = '1.1';

$otw_lcm_plugin_options = get_option( 'otw_cm_plugin_options' );

//load core component functions
@include_once( 'include/otw_components/otw_functions/otw_functions.php' );

//include functons
require_once( plugin_dir_path( __FILE__ ).'/include/otw_lcm_functions.php' );

$otw_lcm_skin = '';

$otw_lcm_skins_path = plugin_dir_path( __FILE__ ).'/skins/';

$otw_lcm_skins = otw_lcm_load_skins( $otw_lcm_skins_path );

if( isset( $otw_lcm_plugin_options['otw_cm_skin'] ) && array_key_exists( $otw_lcm_plugin_options['otw_cm_skin'], $otw_lcm_skins ) ){
	$otw_lcm_skin = $otw_lcm_plugin_options['otw_cm_skin'];
}

//otw components
$otw_lcm_grid_manager_component = false;
$otw_lcm_grid_manager_object = false;
$otw_lcm_shortcode_component = false;
$otw_lcm_form_component = false;
$otw_lcm_validator_component = false;
$otw_lcm_factory_component = false;
$otw_lcm_factory_object = false;


if( !function_exists( 'otw_register_component' ) ){
	wp_die( 'Please include otw components' );
}

//register grid manager component
otw_register_component( 'otw_grid_manager', dirname( __FILE__ ).'/include/otw_components/otw_grid_manager_light/', $otw_lcm_plugin_url.'/include/otw_components/otw_grid_manager_light/' );

//register form component
otw_register_component( 'otw_form', dirname( __FILE__ ).'/include/otw_components/otw_form/', $otw_lcm_plugin_url.'/include/otw_components/otw_form/' );

//register factory component
otw_register_component( 'otw_factory', dirname( __FILE__ ).'/include/otw_components/otw_factory/', $otw_lcm_plugin_url.'/include/otw_components/otw_factory/' );

//register validator component
otw_register_component( 'otw_validator', dirname( __FILE__ ).'/include/otw_components/otw_validator/', $otw_lcm_plugin_url.'/include/otw_components/otw_validator/' );

//register shortcode component
otw_register_component( 'otw_shortcode', dirname( __FILE__ ).'/include/otw_components/otw_shortcode/', $otw_lcm_plugin_url.'/include/otw_components/otw_shortcode/' );

/** 
 *call init plugin function
 */
add_action('init', 'otw_lcm_init' );
?>