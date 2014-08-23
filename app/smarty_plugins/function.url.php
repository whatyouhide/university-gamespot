<?php
/**
 * This file contains the `url` Smarty template function.
 */

/**
 * Smarty plugin.
 * File: function.url.php
 * Type: function
 * Name: image_path
 * Purpose: output a link with GET parameters.
 */
function smarty_function_url($params, $smarty) {
  $base_url = $params['to'];
  unset($params['to']);

  $href = $smarty->getTemplateVars('site_root') . $base_url;

  if (!empty($params)) {
    $href .= '?' . http_build_query($params);
  }

  return $href;
}
?>
