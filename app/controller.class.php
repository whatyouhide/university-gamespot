<?php
class Controller {
  function __construct() {
    // Setup some instance variables.
    $this->smarty = new GamespotSmarty;
    $this->db = new DB;
    $this->request = new Request;
    $this->mailer = new Mailer;

    // Just a proxy to access the current request params.
    $this->params = $this->request->params;

    // Setup the current user.
    $this->setup_current_user();
  }

  // Render the Smarty template asosciated with a given `$template` (which
  // conventionally is inside a directory named after the controller.
  // `$template` refers to a Smarty template.
  // If `$template` doesn't end with '.tpl', GamespotSmarty will take care of
  // that.
  public function render($template, $assigns = array()) {
    $this->smarty->mass_assign($assigns);
    $this->setup_and_clean_flash();
    $this->smarty->display($template);

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

  // Setup the `current_user` instance variable and make it available to
  // Smarty if the user is present.
  private function setup_current_user() {
    if (!Session::user()) return;

    $this->current_user = Session::user();
    $this->smarty->assign('current_user', $this->current_user);
  }
}
?>
