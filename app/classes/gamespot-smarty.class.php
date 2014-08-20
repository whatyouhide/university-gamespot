<?php
/**
 * This file contains a wrapper class around the `Smarty` class.
 * @package Gamespot
 * @subpackage Common
 */

include 'lib/smarty/libs/Smarty.class.php';

/**
 * A wrapper class around the `Smarty` class.
 */
class GamespotSmarty extends Smarty {
  /**
   * Call the parent `__construct` function and setup some Gamespot related
   * stuff.
   */
  function __construct() {
    parent::__construct();
    $this->set_configs();
    $this->basic_assigns();
  }

  /**
   * Assign a bunch of variables to Smarty.
   * @param array $variables An array in the form 'var' => 'value'
   */
  public function mass_assign($variables) {
    foreach ($variables as $key => $val) {
      $this->assign($key, $val);
    }
  }

  /**
   * Overrides the `display` function so that you don't need to end the template
   * name with '.tpl'.
   * @param string $template The name of the template to display
   */
  public function render($template) {
    parent::display($this->with_tpl_extension($template));
  }

  /**
   * Set some Smarty configurations.
   */
  private function set_configs() {
    $this->setTemplateDir(ROOT . '/app/views/');
    $this->setCompileDir(ROOT . '/templates_c/');
    $this->setConfigDir(ROOT . '/configs/');
    $this->setCacheDir(ROOT . '/cache/');
    $this->addPluginsDir(ROOT . '/app/smarty_plugins/');
  }

  /**
   * Assign some Smarty common variables based on environment and constants.
   */
  private function basic_assigns() {
    $this->assign('site_name', SITE_NAME);
    $this->assign('site_root', SITE_ROOT);
    $this->assign('root', ROOT);
    $this->assign('controllers', SITE_ROOT . '/app/controllers');
    $this->assign('uploads', SITE_ROOT . '/public/uploads');
    $this->assign('lib', SITE_ROOT . '/lib');
    $this->assign('javascripts', SITE_ROOT . '/app/assets/javascripts');
    $this->assign('stylesheets', SITE_ROOT . '/app/assets/stylesheets');
    $this->assign('globals', $GLOBALS);
  }

  /**
   * Append '.tpl' to a template name if it doesn't end with it already.
   * @param string $template_name The name of the template
   * @return string The name of the template ending in '.tpl'
   */
  private function with_tpl_extension($template_name) {
    if (!preg_match('/\.tpl$/', $template_name)) {
      $template_name .= '.tpl';
    }

    return $template_name;
  }
}
?>
