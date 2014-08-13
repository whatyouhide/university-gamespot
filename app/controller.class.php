<?php
class Controller {
  // Set up some common instance variables (like a Smarty instance and a DB
  // instance).
  function __construct() {
    $this->smarty = new GamespotSmarty();
    $this->smarty->assign('globals', $GLOBALS);
    $this->db = new DB();
  }

  // Render the Smarty template asosciated with a given `$template` (which
  // conventionally is inside a directory named after the controller.
  // `$template` refers to a Smarty template.
  public function render($template, $assigns = array()) {
    // Assign stuff to Smarty variables.
    foreach ($assigns as $key => $val) {
      $this->smarty->assign($key, $val);
    }

    $this->setup_and_clean_flash();

    // Render the smarty template.
    $this->displayTemplate($template);

    // Kill the script. Rendering is the last thing you want to do.
    die();
  }

  // Render an error page (404.tpl, 500.tpl and so on).
  public function render_error($error_no) {
    http_response_code($error_no);
    $this->render('errors/' . $error_no);
  }

  // Private functions

  // Assign flash variables to smarty and clean the session.
  private function setup_and_clean_flash() {
    $this->smarty->assign('flash', $_SESSION['flash']);
    $_SESSION['flash'] = array();
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

  // Display a Smarty template. If `$template` doesn't end with '.tpl', add it
  // to the name.
  private function displayTemplate($template) {
    $this->smarty->display($this->with_tpl_extension($template));
  }
}
?>
