<?php
/*
Plugin Name: MoneyPress : Commission Junction Edition
Plugin URI: http://www.charlestonsw.com/product/moneypress-commission-junction-edition/
Description: Quickly and easily display products from your Commission Junction affiliate partners on your website. Great for earning affiliate revenue or adding content.
Version: 1.3
Author: Charleston Software Associates
Author URI: http://www.charlestonsw.com
License: GPL3
  
 Copyright (C) 2012 Charlestonn Software Associates

 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License
 as published by the Free Software Foundation; either version 3
 of the License, or (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program. If not, see <http://www.gnu.org/licenses/>.

 */

/// DEBUGGING
/* error_reporting(E_ALL); */
/* ini_set('display_errors', '1'); */


// Drive Path Defines 
//
if (defined('MP_CJ_PLUGINDIR') === false) {
    define('MP_CJ_PLUGINDIR', plugin_dir_path(__FILE__));
}

if (defined('MP_CJ_PLUGINURL') === false) {
    define('MP_CJ_PLUGINURL', plugins_url('',__FILE__));
}

if (defined('MP_CJ_BASENAME') === false) {
    define('MP_CJ_BASENAME', plugin_basename(__FILE__));
}

if (defined('MP_CJ_PREFIX') === false) {
    define('MP_CJ_PREFIX', 'csl-mp-cj');
}

if (defined('MP_EBAY_ADMINPAGE') === false) {
    define('MP_EBAY_ADMINPAGE', get_option('siteurl') . '/wp-admin/admin.php?page=' . MP_CJ_PLUGINDIR );
}

if (defined('MP_CJ_ICONDIR') === false) {
    define('MP_CJ_ICONDIR', MP_CJ_PLUGINDIR . 'images/icons/');
}

if (defined('MP_CJ_ICONURL') === false) {
    define('MP_CJ_ICONURL', MP_CJ_PLUGINURL . 'images/icons/');
}


// Include our needed files
//
global $MP_cj_plugin;
include_once(MP_CJ_PLUGINDIR . '/include/config.php'   );
include_once(MP_CJ_PLUGINDIR . '/include/csl_helpers.php');

if (class_exists('PanhandlerProduct') === false) {
    try {
        require_once('Panhandler/Panhandler.php');
    }
    catch (PanhandlerMissingRequirement $exception) {
        add_action('admin_notices', array($exception, 'getMessage'));
        exit(1);
    }
}
if (class_exists('CommissionJunctionPanhandler') === false) {
    try {
        require_once('Panhandler/Drivers/CommissionJunction.php');
    }
    catch (PanhandlerMissingRequirement $exception) {
        add_action('admin_notices', array($exception, 'getMessage'));
        exit(1);
    }
}

register_activation_hook( __FILE__, 'csl_mpcj_activate');

// actions
add_action('admin_print_styles','csl_mpcj_admin_stylesheet');
add_action('admin_init','csl_mpcj_setup_admin_interface',10);
add_action('wp_footer', 'csl_mpcj_user_stylesheet');
                         
//-----------------------------------------------------------------------------
// LEGACY STUFF - CAN PROBABLY GO AWAY
//-----------------------------------------------------------------------------
if ( is_admin() ) {
  add_action('admin_menu', 'wpCJ_Handle_Admin_Menu');
  add_filter('admin_print_scripts', 'wpCJ_Admin_Head');
}


