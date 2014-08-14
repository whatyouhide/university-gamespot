<?php
include 'lib/smarty/libs/Smarty.class.php';

class GamespotSmarty extends Smarty {
  function __construct() {
    parent::__construct();
    $this->set_configs();
    $this->basic_assigns();
  }

  // Assign a bunch of key => value pairs to the current instance.
  public function mass_assign($variables) {
    foreach ($variables as $key => $val) {
      $this->assign($key, $val);
    }
  }

  // Override the `display` function so that it adds '.tpl' at the end of the
  // template name if it's not already there.
  public function display($template, $cache_id, $compile_id) {
    parent::display(
      $this->with_tpl_extension($template),
      $cache_id,
      $compile_id
    );
  }

  // Private methods

  // Set some Smarty config variables.
  private function set_configs() {
    $this->setTemplateDir(ROOT . '/app/views/');
    $this->setCompileDir(ROOT . '/templates_c/');
    $this->setConfigDir(ROOT . '/configs/');
    $this->setCacheDir(ROOT . '/cache/');
  }

  // Assign some widely used variables to Smarty.
  private function basic_assigns() {
    $this->assign('site_name', SITE_NAME);
    $this->assign('site_root', SITE_ROOT);
    $this->assign('root', ROOT);

    $this->assign('controllers', SITE_ROOT . '/app/controllers');

    $this->assign('uploads', SITE_ROOT . '/public/uploads');

    $this->assign('globals', $GLOBALS);
  }

  // Add a .tpl extension to a template name if needed.
  private function with_tpl_extension($template_name) {
    // Prefix the template (like 'controller/template') with a trailing
    // extension ('.tpl') if it doesn't have one.
    if (!preg_match('/\.tpl$/', $template_name)) {
      $template_name .= '.tpl';
    }

    return $template_name;
  }
}
?>
