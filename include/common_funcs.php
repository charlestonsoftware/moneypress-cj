<?php

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

?>