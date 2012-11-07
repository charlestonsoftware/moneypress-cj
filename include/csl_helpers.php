<?php
/****************************************************************************
 ** file: csl_helpers.php
 **
 ** Generic helper functions.  May live in WPCSL-Generic soon.
 ***************************************************************************/


/**************************************
 ** function: csl_slplus_setup_admin_interface
 **
 ** Builds the interface elements used by WPCSL-generic for the admin interface.
 **/
function csl_mpcj_setup_admin_interface() {
    global $MP_cj_plugin;
    
    // Don't have what we need? Leave.
    if (!isset($MP_cj_plugin)) { return; }    
    
    // Show message if not licensed
    //
    if (get_option(MP_CJ_PREFIX.'-purchased') == 'false') {
        $MP_cj_plugin->notifications->add_notice(
            2,
            "Your license " . get_option(MP_CJ_PREFIX . '-license_key') . " could not be validated."
        );            
    }         
    
    // Already been here?  Get out.
    if (isset($MP_cj_plugin->settings->sections['How to Use'])) { return; }    
    
    // No SimpleXML Support
    if (!function_exists('simplexml_load_string')) {
        $MP_cj_plugin->notifications->add_notice(1, __('SimpleXML is required but not enabled.',MP_CJ_PREFIX));
    }    
    
    //-------------------------
    // How to Use Section
    //-------------------------
    
    $MP_cj_plugin->settings->add_section(
        array(
            'name' => 'How to Use',
            'description' => file_get_contents(MP_CJ_PLUGINDIR.'/how_to_use.txt')
        )
    );
    
   
    //-------------------------
    // Communication Settings
    //-------------------------
    $MP_cj_plugin->settings->add_section(
        array(
                'name' => 'CJ Communications',
                'description' => 'These settings affect how the plugin communicates with Commission Junction to get your listings.<br/><br/>'
             )
        );
    
    $MP_cj_plugin->settings->add_item('CJ Communications', 'CJ Key', 'api_key', 'textarea', true,'Get your key at <a href="http://webservices.cj.com" target="_new">Commission Junction</a>.');
    $MP_cj_plugin->settings->add_item('CJ Communications', 'CJ Web ID (PID)', 'cj_webid', 'text', true,'Get your key at <a href="http://www.cj.com" target="_new">Commission Junction</a>. Look under the accounts/web-settings tab after you log in.');    
    
    
    //-------------------------
    // Product Display
    //-------------------------
    $MP_cj_plugin->settings->add_section(array(
        'name' => 'Product Display',
        'description' => 
        __('The values that are entered here are the defaults whenever you use a shortcode. ' .
            'You can override these settings via the shortcode qualifiers when you put the code into a page or post. ' .
            'For more information see our <a href="http://redmine.cybersprocket.com/projects/cjwp/wiki/MoneyPress_Commission_Junction_Edition_Settings" target="cyber-sprocket-labs">Settings Documentation</a>.',MP_CJ_PREFIX)
        ));
    
    
    $MP_cj_plugin->settings->add_item(
        'Product Display', 
        __('Advertiser IDs',MP_CJ_PREFIX), 
        'advertiser-ids', 
        'text', 
        false,
               "<p>Limits the results to a set of particular advertisers (CIDs) using one of the following four values:</p>
                <ul style=\"list-style: inside;\">
                  <li>
                    <b>CIDs:</b> You may provide a list of one or more
                    advertiser CIDs, separated by commas, to limit the results to a
                    specific sub-set of merchants.
                  </li>
                  <li>
                    <b>Empty String:</b> You may provide an empty string to
                    remove any advertiser-specific restrictions on the search.
                  </li>
                  <li>
                    <b>joined:</b> This special value (<code>joined</code>) restricts the search to avertisers with wich you have a relationship.
                  </li>
                  <li>
                    <b>notjoined:</b> this special value (<code>not-joined</code>) restricts the search to advertisers with which you do not have a relationship.
                  </li>
                </ul>"
         );            
    $MP_cj_plugin->settings->add_item(
        'Product Display', 
        __('Number of products to show',MP_CJ_PREFIX), 
        'records-per-page', 
        'text', 
        false,
         "<p>Specifies the number of records to return in the
         request. Leaving this parameter blank assigns a default value of
         50.</p>
         <p><b>Note:</b> 1000 results is the system limit for results
         per request. If you request a value greater than 1000, the system only
         returns 1000.</p>"
         );
    
    $MP_cj_plugin->settings->add_item(
        'Product Display', 
        __('Keywords',MP_CJ_PREFIX), 
        'keywords', 
        'text', 
        false,
        "<p>This value restricts the search results based on keywords
        found in the advertiser's name, the product name, or the product
        description. This parameter may be left blank if other paramaters
        (such as <code>upc</code>, <code>isbn</code>) are provided. You may
        use simple Boolean logic operators (’r;+’, ’r;-’r;) to obtain more
        relevant search results. By default, the system assumes basic OR
        logic.</p>"
        );
    
    $MP_cj_plugin->settings->add_item(
        'Product Display', 
        __('Serviceable Area',MP_CJ_PREFIX), 
        'serviceable-area', 
        'text', 
        false,
        "<p>Limits the results to a specific set of advertisers' targeted areas.</p>"
        );
    
    $MP_cj_plugin->settings->add_item(
        'Product Display', 
        'ISBN', 
        'isbn', 
        'text', 
        false,
        "<p>Limits the results to a specific product from multiple
        merchants identified by the appropriate unique identifier, ISBN.</p>"
        );
    
    $MP_cj_plugin->settings->add_item(
        'Product Display', 
        'UPC', 
        'upc', 
        'text', 
        false,
        "<p>Limits the results to a specific product from multiple
        merchants identified by the appropriate unique identifier, UPC.</p>"
        );
    
    $MP_cj_plugin->settings->add_item(
        'Product Display', 
        __('Manufacturer\'s Name',MP_CJ_PREFIX), 
        'manufacturer-name', 
        'text', 
        false,
        __("Limits the results to a particular manufacturer's name.",MP_CJ_PREFIX)
         );
    
    $MP_cj_plugin->settings->add_item(
        'Product Display', 
        __('Manufacturer\'s SKU',MP_CJ_PREFIX), 
        'manufacturer-sku', 
        'text', 
        false,
        __("Limits the results to a particular manufacturer's SKU number.",MP_CJ_PREFIX)
         );
    
    $MP_cj_plugin->settings->add_item(
        'Product Display', 
        __('Advertiser SKU',MP_CJ_PREFIX), 
        'advertiser-sku', 
        'text', 
        false,
        __('Limits the results to a particular advertiser SKU.',MP_CJ_PREFIX)
        );
    
    $MP_cj_plugin->settings->add_item(
        'Product Display', 
        __('Low Price',MP_CJ_PREFIX), 
        'low-price', 
        'text', 
        false,
        "<p>Limits the results to products with a price greater than or equal to the <code>low_price</code>.</p>
        <p><b>Tip:</b> Use in conjunction with the <code>high_price</code> to specify a range of prices.</p>
        <p><b>Note:</b> Only whole numbers are supported for this
        request parameter. the <code>low_price</code> parameter is inclusive,
        whereas the <code>high_price</code> parameter is exclusive. For
        example, using a low price of 10 and a high price of 20 will return
        everything from 10 to 19.99.</p>"
        );
    
    $MP_cj_plugin->settings->add_item(
        'Product Display', 
        __('High Price',MP_CJ_PREFIX), 
        'high-price', 
        'text', 
        false,
        "<p>Limits the results to products less than or equal to the <code>high_price</code>.</p>
        <p><b>Tip:</b> Use in conjunction with the <code>low_price</code> to specify a range of prices.</p>
        <p><b>Note:</b> Only whole numbers are supported for this
        request parameter. the <code>low_price</code> parameter is inclusive,
        whereas the <code>high_price</code> parameter is exclusive. For
        example, using a low price of 10 and a high price of 20 will return
        everything from 10 to 19.99.</p>"
        );
    
    $MP_cj_plugin->settings->add_item(
        'Product Display', 
        __('Low Sale Price',MP_CJ_PREFIX), 
        'low-sale-price', 
        'text', 
        false,
        __('Limits the results to products with a price greater than '.
         'or equal to the Advertiser offered <code>low_sale_price</code>. '.
         'Only whole numbers are supported for this '.
         'request parameter. The <code>low_sale_price</code> parameter is '.
         'inclusive, whereas the <code>high_sale_price</code> parameter is '.
         'exclusive. For example, using a low sale price of 10 and a high sale '.
         'price of 20 will return everything from 10 to 19.99.',MP_CJ_PREFIX)
         );
    
    $MP_cj_plugin->settings->add_item(
        'Product Display', 
        __('High Sale Price',MP_CJ_PREFIX), 
        'high-sale-price', 
        'text', 
        false,
        __('Limits the results to products with a price less than or '.
         'equal to the Advertiser offered <code>high_sale_price</code>. '.         
         'Only whole numbers are supported for this request parameter. '. 
         'The <code>low_sale_price</code> parameter is '.
         'inclusive, whereas the <code>high_sale_price</code> parameter is '.
         'exclusive. For example, using a low sale price of 10 and a high sale '.
         'price of 20 will return everything from 10 to 19.99.',MP_CJ_PREFIX)
         );
    
    $MP_cj_plugin->settings->add_item(
        'Product Display', 
        __('Currency',MP_CJ_PREFIX), 
        'currency', 
        'list', 
        false,
         __('Limits the results to the selected currency.',MP_CJ_PREFIX),
         array(
            __('US Dollars',            MP_CJ_PREFIX)   => 'USD',
            __('Euros',                 MP_CJ_PREFIX)   => 'EUR',
            __('Great Britian Pounds',  MP_CJ_PREFIX)   => 'GBP',
         )
         );
    $MP_cj_plugin->settings->add_item(
        'Product Display', 
        __('Sort By',MP_CJ_PREFIX), 
        'sort-by', 
        'list', 
        false,
         __('Sort the results in the response by one of the following values.'.
         'Only the results returned in the particular request are sorted by '.
         'the value of this parameter. The system automatically sorts all '.
         'matching results in the index (not just the results in the specific '.
         'request) by relevance to keyword value sent in the request.',MP_CJ_PREFIX),
         array(
             __('Name',             MP_CJ_PREFIX)   =>  'Name',
             __('Advertiser ID',    MP_CJ_PREFIX)   =>  'Advertiser ID',
             __('Advertiser Name',  MP_CJ_PREFIX)   =>  'Advertiser Name',
             __('Currency',         MP_CJ_PREFIX)   =>  'Currency',
             __('Price',            MP_CJ_PREFIX)   =>  'Price',
             __('Sale Price',       MP_CJ_PREFIX)   =>  'salePrice',
             __('Manufacturer',     MP_CJ_PREFIX)   =>  'Manufacturer',
             __('SKU',              MP_CJ_PREFIX)   =>  'SKU',
             __('UPC',              MP_CJ_PREFIX)   =>  'UPC'
             )
         
         );
    $MP_cj_plugin->settings->add_item(
        'Product Display', 
        __('Sort Order',MP_CJ_PREFIX), 
        'sort-order', 
        'list', 
        false,
        __('Specifies the order in which the results are sorted.',MP_CJ_PREFIX),
        array(
            'Ascending' => 'asc',
            'Descending' => 'desc'
            )
         );
    
    if ($MP_cj_plugin->license->packages['Pro Pack']->isenabled) {
        csl_mpcj_add_settings();
    }
    
}

/**************************************
 ** function: csl_mpcj_activate
 **
 ** Add the admin stylesheets to admin pages.
 **/
function csl_mpcj_activate() {
    global $MP_cj_plugin;

    
    // Force local if not set
    //
    if (get_option(MP_CJ_PREFIX . '-locale') === '') {
        update_option(MP_CJ_PREFIX . '-locale','C');    
    }
    
    // Force Money Format If Not Set
    //
    if (get_option(MP_CJ_PREFIX . '-money_format')  === '') {
        update_option(MP_CJ_PREFIX . '-money_format','%!i');
    }
}

/**************************************
 ** function: csl_mpcj_user_stylesheet
 **
 ** Add the user stylesheets.
 **/
function csl_mpcj_user_stylesheet() {
    global $MP_cj_plugin;
    $MP_cj_plugin->themes->assign_user_stylesheet();
}
    
/**************************************
 ** function: csl_mpcj_admin_stylesheet
 **
 ** Add the admin stylesheets to admin pages.
 **/
function csl_mpcj_admin_stylesheet() {
    if ( file_exists(MP_CJ_PLUGINDIR.'css/admin.css')) {
        wp_enqueue_style('csl_mpcj_admin_css', MP_CJ_PLUGINURL .'css/admin.css');
    }
}



function wpCJ_BuildURL($params) {
  global $cj_defaults;

  foreach ($cj_defaults as $key=>$value) {
    $final_list[$key] = $params[$key] or
      $final_list[$key] = get_option('api_'.$key) or
      $final_list[$key] = $value or
      $final_list[$key] = null;
  }

  return (isset($final_list['advertiser-ids'])) ? http_build_query($final_list) : false;
}

function wpCJ_GetProducts ($params) {
  global $cj_plugin;

  if ($url =  wpCJ_BuildURL($params) ) {
    if (!($data = $cj_plugin->cache->load(md5($url)))) {
      $ch = curl_init();
      $cj_product_search_url = 'https://product-search.api.cj.com/v2/product-search?';
      curl_setopt($ch, CURLOPT_URL, $cj_product_search_url . $url);
      curl_setopt($ch, CURLOPT_POST, FALSE);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: '.get_option('cj_key')));
      $response = curl_exec($ch);

      $data = $response;

      $cj_plugin->cache->save(md5($url), serialize($response));
    }

    return ($data) ? new SimpleXMLElement($data) : false;
  } else return false;
}

function wpCJ_GenerateKeywords($xml) {
  if (!isset($xml->{'products'})) return false;

  $length_threshold = 4;

  foreach ($xml->{'products'}->{'product'} as $CurrentProduct) {
    foreach ( array_map("strtolower",preg_split("/[^a-zA-Z]+/", $CurrentProduct->name)) as $word) {
      if (strlen($word) > $length_threshold) {
        $word_list[$word]++;
      }
    }

    foreach ( array_map("strtolower",preg_split("/[^a-zA-Z]+/", $CurrentProduct->description)) as $word) {
      if (strlen($word) > $length_threshold) {
        $word_list[$word]++;
      }
    }

  }
  $word_list = array_filter($word_list, "wpCJ_threshold_filter");
  array_multisort($word_list, SORT_DESC);

  return $word_list;
}

function wpCJ_threshold_filter($var) {
  $match_threshold = 8;
  return ($var > $match_threshold) ? true : false;
}

function wpCJ_url_exists($url) {
  // Version 4.x supported
  $handle   = curl_init($url);
  if (false === $handle)
    {
      return false;
    }
  curl_setopt($handle, CURLOPT_HEADER, false);
  curl_setopt($handle, CURLOPT_FAILONERROR, true);  // this works
  curl_setopt($handle, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15") ); // request as if Firefox
  curl_setopt($handle, CURLOPT_NOBODY, true);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, false);
  $connectable = curl_exec($handle);
  curl_close($handle);
  return $connectable;
}

