<?php
/**
 * This file contains the 'image_path' Smarty template function.
 */

use Common\Gravatar;

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

  // Add the possibility to use a 'class' attribute for the HTML class
  // attribute.
  $class = isset($params['class']) ? $params['class'] : '';

  // Add the possibility to add a 'data-hoverable' HTML attribute.
  $hoverable = isset($params['hoverable']) ? 'data-hoverable' : '';

  if (isset($params['src'])) {
    $src = $asset_images_path . $params['src'];
  } else if (isset($params['image'])) {
    $src = $uploads_path . '/' . $params['image']->url;
  } else if (!isset($params['image']) && isset($params['gravatar'])) {
    $src = Gravatar::get($params['gravatar']);
  } else if (isset($params['default'])) {
    $src = $asset_images_path . $params['default'];
  } else {
    $src = $asset_images_path . 'default.jpg';
  }

  $output = "<img src=\"$src\" class=\"$class\" $hoverable/>";
  return $output;
}
?>
