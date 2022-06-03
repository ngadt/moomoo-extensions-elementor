<?php
/*
Plugin Name: Moomoo Extensions Elementor
Description: Extensions for Elementor: buttons, media, slides, gravityform style ...
Version: 1.2.9
Author: Ngadt
License: GPLv2 or later
Text Domain: moomoo.sg
*/

define("MM_EXT_ASSET_PATH", plugin_dir_path(__FILE__).'/assets');
define("MM_EXT_ASSET_URL",  plugins_url('assets' ,__FILE__)); 
define("MM_PLUGIN_NAME", plugin_basename( __DIR__ ));
define("MM_PLUGIN_NAME_MAIN_FILE", basename(__FILE__));

require_once('class/meta-box.php');
require_once('extensions/column-extended.php');
require_once('extensions/element-extended.php');
require_once('mm-upgrade.php');

 
/** update html of GravityForm */
add_filter('gform_submit_button','ndt_edit_input_html',10,2);
add_filter('gform_previous_button','ndt_edit_input_html',10,2);
add_filter('gform_next_button','ndt_edit_input_html',10,2);
function ndt_edit_input_html($button_input , $form){

	$re = "/class='\s*(.*?)\s*'/s";
	$str = htmlentities($button_input);
	preg_match_all($re,$str , $matches, PREG_SET_ORDER, 0);
	$class = $matches[0][1];
    $button_input  = '<div class="effect '.$class .'"><span class="mm-blink"></span>'.$button_input.'</div>';	
	return $button_input;

}
/** Add changelog-downloadplugin to plugin */
add_filter( 'plugin_row_meta', 'ndt_add_changelog', 10, 2 );
function ndt_add_changelog($plugin_meta, $plugin_file){
	

	if($plugin_file == MM_PLUGIN_NAME.'/'.MM_PLUGIN_NAME_MAIN_FILE):

	$row_meta = [		
		'changelog' => '<a href="https://raw.githubusercontent.com/ngadt/moomoo-extensions-elementor/master/changelog.txt" title="' . esc_attr( esc_html__( 'View Changelog', 'moomoo-extensions-elementor' ) ) . '" target="_blank">' . esc_html__( 'Changelog', 'moomoo-extensions-elementor' ) . '</a>',
		'downloadplugin'=>'<a href="https://raw.githubusercontent.com/ngadt/moomoo-extensions-elementor/master/moomoo-extensions-elementor.zip" title="' . esc_attr( esc_html__( 'Download latest plugin', 'moomoo-extensions-elementor' ) ) . '" target="_blank">' . esc_html__( 'Download latest plugin', 'moomoo-extensions-elementor' ) . '</a>'
	];

	$plugin_meta = array_merge( $plugin_meta, $row_meta );
	endif;
	return $plugin_meta;
}