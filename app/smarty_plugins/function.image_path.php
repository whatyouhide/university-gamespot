<?php
/**
 * Smarty plugin.
 * File: function.image_path.php
 * Type: function
 * Name: image_path
 * Purpose: output an <img> tag with a missing image if necessary.
 */
function smarty_function_image_path($params, $smarty) {
  $uploads_path = $smarty->getTemplateVars('uploads');
  $asset_images_path = SITE_ROOT . '/app/assets/images/';

  // Return a regular image tag if there's a `src` attribute.
  if (isset($params['src'])) {
    $src = $asset_images_path . $params['src'];
  } else if (isset($params['image'])) {
    $src = $uploads_path . '/' . $params['image']->url;
  } else if (isset($params['default'])) {
    $src = $asset_images_path . $params['default'];
  } else {
    $src = $asset_images_path . 'default.jpg';
  }

  $output = "<img src=\"$src\" class=\"{$params['class']}\"/>";
  return $output;
}
?>
