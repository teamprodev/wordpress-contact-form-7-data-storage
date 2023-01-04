<?php
/* 
Plugin Name: Multi Form Data Storage
Plugin URI: https://codecanyon.net/item/multi-form-data-storage/20494019?ref=quanticalabs
Description: Multi Form Data Storage is a WordPress plugin which allows store, export and manage data from contact forms.
Author: QuanticaLabs
Version: 1.1
Author URI: https://codecanyon.net/user/quanticalabs/portfolio?ref=quanticalabs
*/

load_plugin_textdomain('multi-form-data-storage',false,dirname(plugin_basename(__FILE__)).'/languages/');

require_once('include.php');

$Plugin=new MFDSPlugin();

register_activation_hook(__FILE__,array($Plugin,'pluginActivation'));

add_action('init',array($Plugin,'init'));
add_action('after_setup_theme',array($Plugin,'setupTheme'));