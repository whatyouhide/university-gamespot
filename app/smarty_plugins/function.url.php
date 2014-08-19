<?php
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

  $href = $smarty->getTemplateVars('site_root');
  $href .= '/' . $base_url;
  $href .= '?' . http_build_query($params);

  return $href;
}
?>
