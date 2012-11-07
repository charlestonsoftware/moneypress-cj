<?php
global $MP_cj_plugin;

// Update license key only
//
$new_license = false;
$lkPrefix = $MP_cj_plugin->license->packages['Pro Pack']->prefix .
          '-'.
          $MP_cj_plugin->license->packages['Pro Pack']->sku
        ;

$lkName = $lkPrefix . '-lk';
if (!$MP_cj_plugin->license->packages['Pro Pack']->isenabled_after_forcing_recheck() && isset($_POST[$lkName])) {
    update_option($lkName, $_POST[$lkName]);
    update_option($lkPrefix.'-isenabled', $MP_cj_plugin->license->packages['Pro Pack']->isenabled_after_forcing_recheck());
    $new_license = true;
}


// Instantiate the form rendering object
//
global $cjPlusSettings;
$cjPlusSettings = new wpCSL_settings__mpcj(
    array(
            'no_license'        => true,
            'prefix'            => $MP_cj_plugin->prefix,
            'css_prefix'        => $MP_cj_plugin->css_prefix,
            'url'               => $MP_cj_plugin->url,
            'name'              => $MP_cj_plugin->name . ' - Pro Pack Settings',
            'plugin_url'        => $MP_cj_plugin->plugin_url,
            'form_action'       => admin_url().'/admin.php?page='.$MP_cj_plugin->prefix.'-pro_options',
            'themes_enabled'    => true,
            'render_csl_blocks' => false,
            'settings_obj_name' => 'default'
        )
 );

//-------------------------
// Navbar Section
//-------------------------
//
$cjPlusSettings->add_section(
    array(
        'name' => 'Navigation',
        'div_id' => 'mp_cj_navbar',
        'description' => $MP_cj_plugin->helper->get_string_from_phpexec(MP_CJ_PLUGINDIR.'/templates/navbar.php'),
        'is_topmenu' => true,
        'auto' => false
    )
);



// Pro Pack Only
//
if ($MP_cj_plugin->license->packages['Pro Pack']->isenabled_after_forcing_recheck()) {

    //-------------------
    // Update PRO Options
    //-------------------
    if (!$new_license && $_POST) {
        update_option(MP_CJ_PREFIX.'-theme',$_POST[MP_CJ_PREFIX.'-theme']);


        // Checkboxes with normal names
        //
        $BoxesToHit = array(
            'show_bin_price',
            );
        foreach ($BoxesToHit as $JustAnotherBox) {
            $MP_cj_plugin->helper->SaveCheckBoxToDB($JustAnotherBox);
        }

        // Textboxes with normal names
        //
        $BoxesToHit = array(
            'custom_css',
            'money_prefix',
            );
        foreach ($BoxesToHit as $JustAnotherBox) {
            $MP_cj_plugin->helper->SaveTextboxToDB($JustAnotherBox);
        }
    }

    //-------------------------
    // Display Settings Section
    //-------------------------
    //
    $cjPlusSettings->add_section(
        array(
            'name' => __('Display Settings',MP_CJ_PREFIX),
            'description' => ''
        )
    );
    $MP_cj_plugin->themes->add_admin_settings($cjPlusSettings);


    $cjPlusSettings->add_item(
        __('Display Settings',MP_CJ_PREFIX),
        __('Show Buy It Now Price',MP_CJ_PREFIX),
        'show_bin_price',
        'checkbox',
        false,
        __('When checked, show the BIN price next to the Buy It Now indicator.', MP_CJ_PREFIX)
        );

    $cjPlusSettings->add_item(
        __('Display Settings',MP_CJ_PREFIX),
        __('Money Prefix',MP_CJ_PREFIX),
        'money_prefix',
        'text',
        false,
        __('What character do we put in front of money? (default $)', MP_CJ_PREFIX)
        );

    // Custom CSS Field
    //
    $cjPlusSettings->add_item(
            'Display Settings',
            __('Custom CSS',MP_CJ_PREFIX),
            'custom_css',
            'textarea',
            false,
            __('Enter your custom CSS, preferably for styling this plugin only but it can be used for any page element as this will go in your page header.',MP_CJ_PREFIX),
            null,
            null,
            !$this->parent->license->packages['Pro Pack']->isenabled
            );

} else {

    //-------------------------
    // Info Panel
    //-------------------------
    //
    $cjPlusSettings->add_section(
        array(
            'name' => __('Pro Pack',MP_CJ_PREFIX),
            'description' =>
                __('The Pro Pack extends the features and settings of this plugin.', MP_CJ_PREFIX) .
                '<br/>'.
                sprintf(__('Visit <a href="%s">%s</a> to learn more.', MP_CJ_PREFIX), $MP_cj_plugin->purchase_url, $MP_cj_plugin->purchase_url) .
                '<div style="clear:both;">' . $MP_cj_plugin->settings->ListThePackages(false) . '</div>'
        )
    );
}


$cjPlusSettings->render_settings_page();


?>

