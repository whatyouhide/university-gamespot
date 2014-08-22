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
   * @var array Instance variables that won't be passed to the rendered template
   *            automatically.
   */
  protected $hidden_instance_variables;

  /**
   * @var Smarty A Smarty instance.
   */
  protected $smarty;

  /**
   * @var Request A request instance for the current request.
   */
  protected $request;

  /**
   * @var Mailer A mailer instance.
   */
  protected $mailer;

  /**
   * @var string The action to cal on the newly created controller.
   */
  private $action_to_call;

  /**
   * Create a new controller object and call `$action` on it.
   * @param string $action The action to call on the newly created controller.
   */
  function __construct($action) {
    $this->set_hidden_instance_variable('action_to_call', $action);

    $this->setup_external_instance_variables();
    $this->setup_current_user();
    $this->assign_smarty_default_variables();

    // Just a proxy to access the current request params.
    $this->set_hidden_instance_variable('params', $this->request->params);
  }

  /**
   * Render the Smarty template at `$template` (which is conventionally located
   * inside a directory with the same name of the current controller).
   * Also assign every instance variable of the controller which is not
   * container in `$hidden_instance_variable` to the Smarty instance (à là
   * Rails).
   * @param string $template A template path. If this doesn't end with '.tpl',
   * it will be taken care of automagically.
   * @param array $assigns An array of 'name' => 'value' which is passed to
   * Smarty in order to assign variables.
   */
  public function render($template, $assigns = array()) {
    $this->setup_and_clean_flash();
    $this->assign_non_hidden_variables_to_smarty();
    $this->smarty->mass_assign($assigns);
    $this->smarty->render($template);

    // Rendering is the last thing you want to do.
    die();
  }

  /**
   * Render plain text.
   * @param string $plain_text
   */
  public function render_plain($plain_text) {
    echo $plain_text;
  }

  /**
   * Render an error page and set the HTTP response code.
   * @param int|string $error An error number which will render the
   * corresponding template in 'errors/' like 'errors/404_not_found.tpl',
   * or an error name (like 'not_found') which will be translated to an
   * error code.
   * @param array $additional_data This data will be passed as is to the
   * rendered template.
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
   * Call the `action_to_call` action or render a 404 not found if there's no
   * such action.
   */
  public function dispatch() {
    $action = $this->action_to_call;

    if (method_exists($this, $action)) {
      $this->$action();
    } else {
      $this->render_error(404);
    }
  }

  /**
   * The name of this controller.
   * @return string The name of this controller, lowercase and without the
   *         `Controller` part.
   */
  protected function controller_name() {
    // Get the name of this controller without the 'Controller' at the end.
    $name = str_replace('Controller', '', get_class($this));

    // Split it into words (based on camel casing) and make it all lowercase.
    $words = array_filter(preg_split('/(?=[A-Z])/', $name));
    $words = array_map(function ($w) { return strtolower($w); }, $words);

    return implode('_', $words);
  }

  /**
   * Setup some instance variables.
   */
  private function setup_external_instance_variables() {
    $this->set_hidden_instance_variable('smarty', new GamespotSmarty);
    $this->set_hidden_instance_variable('request', new Request);
    $this->set_hidden_instance_variable('mailer', new Mailer);
  }

  /**
   * Assign all the instance variables of this controller to the Smarty instance
   * attached to this controller, except for the instance variables listed in
   * the `$hidden_instance_variables` array.
   */
  private function assign_non_hidden_variables_to_smarty() {
    $all_variables = get_object_vars($this);

    foreach ($all_variables as $var => $value) {
      if (!in_array($var, $this->hidden_instance_variables)) {
        $this->smarty->assign($var, $value);
      }
    }
  }

  /**
   * Assign the 'flash' Smarty variable and clean the flash from the session.
   */
  private function setup_and_clean_flash() {
    $this->smarty->assign('flash', Session::current_flash());
    Session::empty_flash();
  }

  /**
   * Assign some common Smarty variables like the controller name and action.
   */
  private function assign_smarty_default_variables() {
    $this->smarty->assign('controller_name', $this->controller_name());
    $this->smarty->assign('controller_action', $this->action_to_call);
  }

  /**
   * Setup the `current_user` instance variable if there's a logged in user, and
   * assign that same variable to Smarty.
   */
  private function setup_current_user() {
    if (Session::user()) {
      $this->current_user = Session::user();
    }
  }

  /**
   * Assign a value to an instance variable and add the instance variable to the
   * list of hidden instance variables (the ones that won't be passed to the
   * rendered template automatically).
   * @param string $name The name of the instance variable to set.
   * @param mixed $value The value of the instance variable.
   */
  private function set_hidden_instance_variable($name, $value) {
    // Start with an array with only the `hidden_instance_variables` variable in
    // it.
    if (!isset($this->hidden_instance_variables)) {
      $this->hidden_instance_variables = ['hidden_instance_variables'];
    }

    // Add the instance variable to the array of hidden instance variables.
    array_push($this->hidden_instance_variables, $name);

    // Set the instance variables.
    $this->$name = $value;
  }
}
?>
