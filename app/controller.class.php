<?php
class Controller {
  // Set up some common instance variables (like a Smarty instance and a DB
  // instance).
  function __construct() {
    $this->smarty = new GamespotSmarty();
    $this->db = new DB();
  }

  // Render the Smarty template asosciated with a given `$template` (which
  // conventionally is inside a directory named after the controller.
  // `$template` refers to a Smarty template. If `$template` doesn't end with
  // '.tpl', add it to the name.
  public function render($template, $assigns) {
    // Assign stuff to Smarty variables.
    foreach ($assigns as $key => $val) {
      $this->smarty->assign($key, $val);
    }

    // Prefix the template (like 'controller/template') with a trailing
    // extension ('.tpl') if it doesn't have one.
    if (!preg_match('/\.tpl$/', $template)) {
      $template = $template . '.tpl';
    }

    // Render the smarty template.
    $this->smarty->display($template);

    // Kill the script. Rendering is the last thing you want to do anyway.
    die();
  }
}
?>
