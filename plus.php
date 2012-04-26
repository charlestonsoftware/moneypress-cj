<?php
/****************************************************************************
 ** file: plus.php
 **
 ** Things that are not part of the LE product
 ***************************************************************************/
 
  
/**************************************
 ** function: csl_mpcj_add_settings()
 ** 
 ** Add plus settings to the admin interface.
 **
 **/
function csl_mpcj_add_settings() {
    global $MP_cj_plugin;
    
    $MP_cj_plugin->settings->add_section(
        array(
            'name'          => __('Display Settings',MP_CJ_PREFIX),
            'description'   => ''
        )
    );    
    
    $MP_cj_plugin->settings->add_item(
        'Display Settings', 
        __('Link Modifiers',MP_CJ_PREFIX), 
        'link_modifiers', 
        'text', 
        false,
        __('Enter any modifiers you want to add to the external product link. ' .
        'Must be a fully formed anchor (A tag) qualifier.  Example: rel="nofollow"',MP_CJ_PREFIX)
    );    
}

