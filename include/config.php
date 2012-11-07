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
            'prefix'                => MP_CJ_PREFIX,
            'cache_path'            => MP_CJ_PLUGINDIR . 'cache',
            'plugin_url'            => MP_CJ_PLUGINURL,
            'plugin_path'           => MP_CJ_PLUGINDIR,
            'basefile'              => MP_CJ_BASENAME,

            'name'                  => 'MoneyPress : Commission Junction Edition',
            'url'                   => 'http://www.charlestonsw.com/product/moneypress-commission-junction-edition/',
            'support_url'           => 'http://wordpress.org/support/plugin/moneypress-commission-junction-le',
            'purchase_url'          => 'http://www.charlestonsw.com/product/moneypress-commission-junction-edition/',
            'rate_url'              => 'http://wordpress.org/support/view/plugin-reviews/moneypress-commission-junction-le',
            'forum_url'             => 'http://wordpress.org/support/plugin/moneypress-commission-junction-le',

            'has_packages'           => true,

            'use_obj_defaults'      => true,
            'no_default_css'        => false,
            'css_prefix'            => 'csl_themes',
            'cache_obj_name'        => 'mpcjcache',

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
