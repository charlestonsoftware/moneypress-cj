<?php
/* INCLUDES */
include_once('common_funcs.php');

if (!class_exists('wpCSL_plugin')) {
  include_once(CJPLUGINDIR . 'WPCSL-generic/CSL-plugin.php');
}

global $cj_plugin;
$cj_plugin = new wpCSL_plugin(array(
                                    'use_obj_defaults' => true,
                                    'prefix' => 'mpcj',
                                    'name' => 'MoneyPress Commision Junction LE',
                                    'url' => 'http://www.cybersprocket.com/products/wpcjproductsearch/',
                                    'plugin_path' => CJPLUGINDIR,
                                    'plugin_url' => CJPLUGINURL,
                                    'cache_path' => CJPLUGINDIR . 'cache',
                                    'driver_name' => 'CommissionJunction',
                                    'driver_args' => array(get_option('cj_key'), get_option('cj_webid')),
                                    'shortcodes' => array('cj_show-items', 'cj_show_items')
                                    ));

include_once('settings.php');

