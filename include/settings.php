<?php

$cj_plugin->settings->add_section(array(
                                        'name' => 'Primary Settings',
                                        'description' => '<p>You will need to sign up for an account at <a href="http://webservices.cj.com" target="_new">Commission Junction</a> to fill in these fields.</p>'
                                        ));

$cj_plugin->settings->add_item('Primary Settings', 'Commission Junction Key', 'cj_key', 'textarea', true);
$cj_plugin->settings->add_item('Primary Settings', 'Commission Junction Web ID', 'cj_webid', 'text', true);

$cj_plugin->settings->add_section(array(
                                  'name' => 'API Settings',
                                  'description' => '<p>These are your personal defaults, they can be individually overridden when you insert your shortcodes.</p>
                                                    <p>Example:</p>
                                                    <p><code>[cj_show_items keywords="flower" records_per_page="15"]</code></p>'
                                  ));

$cj_plugin->settings->add_item('API Settings', 'Advertiser IDs', 'advertiser-ids', 'text', false,
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
$cj_plugin->settings->add_item('API Settings', 'Keywords', 'keywords', 'text', false,
                         "<p>This value restricts the search results based on keywords
            found in the advertiser's name, the product name, or the product
            description. This parameter may be left blank if other paramaters
            (such as <code>upc</code>, <code>isbn</code>) are provided. You may
            use simple Boolean logic operators (’r;+’, ’r;-’r;) to obtain more
            relevant search results. By default, the system assumes basic OR
            logic.</p>"
                         );
$cj_plugin->settings->add_item('API Settings', 'Serviceable Area', 'serviceable-area', 'text', false,
                         "<p>Limits the results to a specific set of advertisers' targeted areas.</p>"
                         );
$cj_plugin->settings->add_item('API Settings', 'ISBN', 'isbn', 'text', false,
                         "<p>Limits the results to a specific product from multiple
                         merchants identified by the appropriate unique identifier, ISBN.</p>"
                         );
$cj_plugin->settings->add_item('API Settings', 'UPC', 'upc', 'text', false,
                         "<p>Limits the results to a specific product from multiple
                         merchants identified by the appropriate unique identifier, UPC.</p>"
                         );
$cj_plugin->settings->add_item('API Settings', 'Manufacturer\'s Name', 'manufacturer-name', 'text', false,
                         "<p>Limits the results to a particular manufacturer's name.</p>"
                         );
$cj_plugin->settings->add_item('API Settings', 'Manufacturer\'s SKU', 'manufacturer-sku', 'text', false,
                         "<p>Limits the results to a particular manufacturer's SKU number.</p>"
                         );
$cj_plugin->settings->add_item('API Settings', 'Advertiser SKU', 'advertiser-sku', 'text', false,
                         "<p>Limits the results to a particular advertiser SKU.</p>"
                         );
$cj_plugin->settings->add_item('API Settings', 'Low Price', 'low-price', 'text', false,
                         "<p>Limits the results to products with a price greater than or equal to the <code>low_price</code>.</p>
                         <p><b>Tip:</b> Use in conjunction with the <code>high_price</code> to specify a range of prices.</p>
                         <p><b>Note:</b> Only whole numbers are supported for this
                         request parameter. the <code>low_price</code> parameter is inclusive,
                         whereas the <code>high_price</code> parameter is exclusive. For
                         example, using a low price of 10 and a high price of 20 will return
                         everything from 10 to 19.99.</p>"
                         );
$cj_plugin->settings->add_item('API Settings', 'High Price', 'high-price', 'text', false,
                         "<p>Limits the results to products less than or equal to the <code>high_price</code>.</p>
                         <p><b>Tip:</b> Use in conjunction with the <code>low_price</code> to specify a range of prices.</p>
                         <p><b>Note:</b> Only whole numbers are supported for this
                         request parameter. the <code>low_price</code> parameter is inclusive,
                         whereas the <code>high_price</code> parameter is exclusive. For
                         example, using a low price of 10 and a high price of 20 will return
                         everything from 10 to 19.99.</p>"
                         );
$cj_plugin->settings->add_item('API Settings', 'Low Sale Price', 'low-sale-price', 'text', false,
                         "<p>Limits the results to products with a price greater than
                         or equal to the Advertiser offered <code>low_sale_price</code>.</p>
                         <p><b>Note:</b> Only whole numbers are supported for this
                         request parameter. The <code>low_sale_price</code> parameter is
                         inclusive, whereas the <code>high_sale_price</code> parameter is
                         exclusive. For example, using a low sale price of 10 and a high sale
                         price of 20 will return everything from 10 to 19.99.</p>"
                         );
$cj_plugin->settings->add_item('API Settings', 'High Sale Price', 'high-sale-price', 'text', false,
                         "<p>Limits the results to products with a price less than or
                         equal to the Advertiser offered <code>high_sale_price</code>.</p>
                         <p><b>Note:</b> Only whole numbers are supported for this
                         request parameter. The <code>low_sale_price</code> parameter is
                         inclusive, whereas the <code>high_sale_price</code> parameter is
                         exclusive. For example, using a low sale price of 10 and a high sale
                         price of 20 will return everything from 10 to 19.99.</p>"
                         );
$cj_plugin->settings->add_item('API Settings', 'Currency', 'currency', 'text', false,
                         "<p>Limits the results to one of the following currencies:</p>
                         <ul style=\"list-style: inside;\">
                         <li>USD</li>
                         <li>EUR</li>
                         <li>GBP</li>
                         </ul>"
                         );
$cj_plugin->settings->add_item('API Settings', 'Sort By', 'sort-by', 'text', false,
                         "<p>Sort the results in the response by one of the following values.</p>
                         <ul style=\"list-style: inside;\">
                         <li>Name</li>
                         <li>Advertiser ID</li>
                         <li>Advertiser Name</li>
                         <li>Currency</li>
                         <li>Price</li>
                         <li>salePrice</li>
                         <li>Manufacturer</li>
                         <li>SKU</li>
                         <li>UPC</li>
                         </ul>
                         <p><b>Note:</b> Only the results returned in the particular
                         request are sorted by the value of this parameter. The system
                         automatically sorts all matching results in the index (not just the
                         results in the specific request) by relevance to keyword value sent in
                         the request.</p>"
                         );
$cj_plugin->settings->add_item('API Settings', 'Sort Order', 'sort-order', 'text', false,
                         "<p>Specifies the order in which the results are sorted; the following case-insensitive values are acceptable:</p>
                         <ul style=\"list-style: inside;\">
                         <li><b>asc:</b> ascending (default value)</li>
                         <li><b>dec:</b> descending</li>
                         </ul>"
                         );
$cj_plugin->settings->add_item('API Settings', 'Items Per Page', 'records-per-page', 'text', false,
                         "<p>Specifies the number of records to return in the
                         request. Leaving this parameter blank assigns a default value of
                         50.</p>
                         <p><b>Note:</b> 1000 results is the system limit for results
                         per request. If you request a value greater than 1000, the system only
                         returns 1000.</p>"
                         );

?>