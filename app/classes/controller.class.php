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

  /**
   * Render the Smarty template at `$template` (which is conventionally located
   * inside a directory with the same name of the current controller).
   * @param string $template A template path. If this doesn't end with '.tpl',
   *        it will be taken care of automagically.
   * @param array $assigns An array of 'name' => 'value' which is passed to
   *        Smarty in order to assign variables.
   */
  public function render($template, $assigns = array()) {
    $this->setup_and_clean_flash();
    $this->smarty->mass_assign($assigns);
    $this->smarty->render($template);

    // Rendering is the last thing you want to do.
    die();
  }

  /** Render an error page and set the HTTP response code.
   * @param int|string $error_no An error number which will render the
   *        corresponding template in 'errors/', like 'errors/404.tpl'.
   */
  public function render_error($error_no) {
    http_response_code($error_no);
    $this->render('errors/' . $error_no);
  }

  /**
   * Assign the 'flash' Smarty variable and clean the flash from the session.
   */
  private function setup_and_clean_flash() {
    $this->smarty->assign('flash', Session::current_flash());
    Session::empty_flash();
  }

  /**
   * Setup the `current_user` instance variable if there's a logged in user, and
   * assign that same variable to Smarty.
   */
  private function setup_current_user() {
    if (!Session::user()) return;

    $this->current_user = Session::user();
    $this->smarty->assign('current_user', $this->current_user);
  }
}
?>
