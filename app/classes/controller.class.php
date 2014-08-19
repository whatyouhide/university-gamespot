<?php
/**
 * The base controller class (every controller inherits from this class).
 * @package Gamespot
 * @subpackage Controllers
 */
class Controller {
  /**
   * @var array An associative array that maps named HTTP error to codes.
   */
  private static $message_to_code = array(
    'forbidden' => 403,
    'not_found' => 404,
    'method_not_allowed' => 405,
    'internal_server_error' => 500
  );

  /**
   * @var string The action to cal on the newly created controller.
   */
  private $action_to_call;

  /**
   * Create a new controller object and call `$action` on it.
   * @param string $action The action to call on the newly created controller.
   */
  function __construct($action) {
    $this->action_to_call = $action;

    // Setup some instance variables.
    $this->smarty = new GamespotSmarty;
    $this->db = new DB;
    $this->request = new Request;
    $this->mailer = new Mailer;

    // Just a proxy to access the current request params.
    $this->params = $this->request->params;

    // Setup the current user.
    $this->setup_current_user();

    // Assign the controller name and the controller action to Smarty variables.
    $this->smarty->assign('controller_name', $this->controller_name());
    $this->smarty->assign('controller_action', $this->action_to_call);

    // Call the action.
    $action = $this->action_to_call;
    $this->$action();
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

  /**
   * Render an error page and set the HTTP response code.
   * @param int|string $error_no An error number which will render the
   *        corresponding template in 'errors/' like 'errors/404_not_found.tpl',
   *        or an error name (like 'not_found') which will be translated to an
   *        error code.
   * @param array $additional_data This data will be passed as is to the
   *        rendered template.
   */
  public function render_error($error, $additional_data = array()) {
    if (is_int($error)) {
      $error_no = $error;
      $message = array_search($error_no, self::$message_to_code);
      $template_name = "{$error_no}_{$message}";
    } else {
      $error_no = self::$message_to_code[$error];
      $template_name = "{$error_no}_{$error}";
    }

    http_response_code($error_no);
    $this->render('errors/' . $template_name, $additional_data);
  }

  /**
   * Render the proper error for when a request method is not allowed on an
   * action.
   */
  public function method_not_allowed() {
    $this->render_error('method_not_allowed', [
      'method' => $this->request->method()
    ]);
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

  /**
   * The name of this controller.
   * @return string The name of this controller, lowercase and without the
   *         `Controller` part.
   */
  private function controller_name() {
    $name = strtolower(get_class($this));
    return str_replace('controller', '', $name);
  }
}
?>
