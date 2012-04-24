<?php
/**
 * We need the generic WPCSL plugin class, since that is the
 * foundation of much of our plugin.  So here we make sure that it has
 * not already been loaded by another plugin that may also be
 * installed, and if not then we load it.
 */
if (defined('MP_CJ_PLUGINDIR')) {
    if (class_exists('wpCSL_plugin__mpcj') === false) {
        require_once(MP_CJ_PLUGINDIR.'WPCSL-generic/classes/CSL-plugin.php');
    }
    
    global $MP_cj_plugin;
    $MP_cj_plugin = new wpCSL_plugin__mpcj(
        array(
            'use_obj_defaults'      => true,
            'cache_obj_name'        => 'mpcjcache',
            'prefix'                => MP_CJ_PREFIX,
            'css_prefix'            => 'csl_themes',            
            'name'                  => 'MoneyPress : Commission Junction Edition',
            'url'                   => 'http://www.cybersprocket.com/products/wpcjproductsearch/',
            'support_url'           => 'http://redmine.cybersprocket.com/projects/cjwp/wiki',
            'purchase_url'          => 'http://www.cybersprocket.com/products/wpcjproductsearch/',
            'basefile'              => MP_CJ_BASENAME,
            'plugin_path'           => MP_CJ_PLUGINDIR,
            'plugin_url'            => MP_CJ_PLUGINURL,
            'cache_path'            => MP_CJ_PLUGINDIR . 'cache',
            'driver_name'           => 'CommissionJunction',
            'driver_type'           => 'Panhandler',
            'driver_args'           => array(
                    'api_key'   => get_option(MP_CJ_PREFIX.'-api_key'),
                    'cj_pid'    => get_option(MP_CJ_PREFIX.'-cj_pid'),
                    'cj_webid'  => get_option(MP_CJ_PREFIX.'-cj_webid'),
                    'return'    => get_option(MP_CJ_PREFIX.'-return'),
                    'wait_for'  => get_option(MP_CJ_PREFIX.'-wait_for')
                    ),
            'shortcodes'            => array('mpcj','mp-cj','mp_cj', 'cj_show-items', 'cj_show_items'),
            
            'has_packages'           => true,                
        )
    );    
    
    // Setup our optional packages
    //
    add_options_packages_for_mpcj();           
}

/**************************************
 ** function: add_options_packages_for_mpcj
 **
 ** Setup the option package list.
 **/
function add_options_packages_for_mpcj() {
    configure_mpcj_propack();
}


/**************************************
 ** function: configure_mpcj_propack
 **
 ** Configure the Pro Pack.
 **/
function configure_mpcj_propack() {
    global $MP_cj_plugin;
   
    // Setup metadata
    //
    $MP_cj_plugin->license->add_licensed_package(
            array(
                'name'              => 'Pro Pack',
                'help_text'         => 'A variety of enhancements are provided with this package.  ' .
                                       'See the <a href="'.$MP_cj_plugin->purchase_url.'" target="Cyber Sprocket">product page</a> for details.  If you purchased this add-on ' .
                                       'come back to this page to enter the license key to activate the new features.',
                'sku'               => 'MPCJ',
                'paypal_button_id'  => 'WXZH2ATCDAJ4Y',
                'paypal_upgrade_button_id' => 'WXZH2ATCDAJ4Y'
            )
        );
    
    // Enable Features Is Licensed
    //
    if ($MP_cj_plugin->license->packages['Pro Pack']->isenabled_after_forcing_recheck()) {
             //--------------------------------
             // Enable Themes
             //
             $MP_cj_plugin->themes_enabled = true;
             $MP_cj_plugin->themes->css_dir = MP_CJ_PLUGINDIR . 'css/';
    }        
}
