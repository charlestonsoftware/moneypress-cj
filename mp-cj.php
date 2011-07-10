<?php
/*
  Plugin Name: MoneyPress : Commission Junction LE
  Plugin URI: http://www.cybersprocket.com/products/wpcjproductsearch/
  Description: Quickly and easily display products from your Commission Junction affiliate partners on your website. Great for earning affiliate revenue or adding content.
  Version: 1.0.8
  Author: Cyber Sprocket Labs
  Author URI: http://www.cybersprocket.com
  License: GPL3
  
	Copyright 2011  Cyber Sprocket Labs (info@cybersprocket.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('CJPLUGINDIR', plugin_dir_path(__FILE__));
define('CJPLUGINURL', plugins_url('',__FILE__));

include_once('include/config.php');


if ( is_admin() ) {
  add_action('admin_menu', 'wpCJ_Handle_Admin_Menu');
  add_filter('admin_print_scripts', 'wpCJ_Admin_Head');
} else {
  // non-admin enqueues, actions, and filters
}


//////////// FUNCTIONS

// Not being used currently, will require heavy reworking to interface with Wordpress properly
function wpCJ_keyword_list($keywords) {
  foreach ($keywords as $keyword=>$count) {
    $keyword_path = ((isset($search_keywords)) ? str_replace(' ', '/', $search_keywords) : '') . "/";
    // Not sure whether or not the links should be addative at this point...
    // echo "<a href='" . ROOT_POSTFIX . "/$keyword_path$keyword'>$keyword</a> \n";
    echo "<a href='" . ROOT_POSTFIX . "/$keyword'>$keyword</a> \n";
  }
}

function wpCJ_Handle_Admin_Menu() {
  global $cj_plugin;

  if ($cj_plugin->settings->check_required('Primary Settings')) {
    add_meta_box('wpcjStoreMB', 'CSL Quick Commission Junction Entry', 'wpCJ_StoreInsertForm', 'post', 'normal');
    add_meta_box('wpcjStoreMB', 'CSL Quick Commission Junction Entry', 'wpCJ_StoreInsertForm', 'page', 'normal');
  }
}

function wpCJ_Admin_Head () {
  if ($GLOBALS['editing']) {
    wp_enqueue_script('wpCJStoreAdmin', plugins_url('js/cjstore.js', __FILE__), array('jquery'), '1.0.0');
  }
}

function wpCJ_StoreInsertForm() {
?>
<table class="form-table">
  <tr valign="top">
    <th align="right" scope="row"><label for="wpCJ_keywords"><?php _e('Keywords:')?></label></th>
    <td>
      <input type="text" size="40" style="width:95%;" name="wpCJ_keywords" id="wpCJ_keywords" />
    </td>
  </tr>
  <tr valign="top">
    <th align="right" scope="row"><label for="wpCJ_itemcount"><?php _e('Number of Items:')?></label></th>
    <td>
      <select name="wpCJ_itemcount" id="wpCJ_itemcount">
        <option>1</option>
        <option>5</option>
        <option>10</option>
        <option>20</option>
        <option>50</option>
      </select>
    </td>
  </tr>
</table>
<p class="submit">
  <input type="button" onclick="return this_wpCJAdmin.sendToEditor(this.form);" value="<?php _e('Create Commission Junction Shortcode &raquo;'); ?>" />
</p>
<?php
}

?>