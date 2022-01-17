<?php
/*
Plugin Name: Moomoo Extensions Elementor
Plugin URI: --
Description: Extensions for Elementor: buttons, media, slides, gravityform style ...
Version: 1.2.3
Author: Ngadt
License: GPLv2 or later
Text Domain: moomoo.sg
*/

define("MM_EXT_ASSET_PATH", plugin_dir_path(__FILE__).'/assets');
define("MM_EXT_ASSET_URL",  plugins_url('assets' ,__FILE__)); 

require_once('class/meta-box.php');
require_once('extensions/column-extended.php');
require_once('extensions/element-extended.php');





