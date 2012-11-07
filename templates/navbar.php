<?php
/****************************************************************************
 ** file: templates/navbar.php
 **
 ** The top navigation bar.
 ***************************************************************************/
?>

<ul>
    <li class='like-a-button'><a href="<?php echo admin_url(); ?>options-general.php?page=csl-mp-cj-options">Settings: General</a></li>
</ul>


<?php
/****************************************************************************
 ** file: core/templates/navbar.php
 **
 ** The top Store Locator Settings navigation bar.
 ***************************************************************************/

// Put all SLP sidebar nav items in main navbar
//
global $submenu, $MP_cj_plugin;
$content =
    '<ul>';

// Loop through all SLP sidebar menu items on admin page
//
foreach ($submenu[MP_CJ_PREFIX . '-options'] as $menu_item) {

    // Create top menu item
    //
    $content .= apply_filters(
            'slp_navbar_item_tweak',
            '<a href="'.menu_page_url( $menu_item[2], false ).'">'.
                "<li class='like-a-button'>$menu_item[0]</li>".
            '</a>'
            );
}
$content .= apply_filters('mpcj_navbar_item','');
$content .='</ul>';
echo apply_filters('mpcj_navbar',$content);



?>