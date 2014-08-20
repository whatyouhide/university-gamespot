<?php
/**
 * The singleton class that handles routing in the application.
 * @package Gamespot
 * @subpackage Common
 */
class Router {
  /**
   * Dispatch an action to a controller based on the parameters that the .htaccess
   * set in the `$_GET` array.
   * Default to 'application' for the controller, and 'index' for the action.
   * <code>
   * some_controller/some_action      # the action is 'some_action'
   * some_controller/                 # defaults to the 'index' action
   * </code>
   *
   * @param string $c The controller name, for example 'ads' (defaults to
   * 'application').
   * @param string $a The action to call on the controller, for example 'show'
   * (defaults to 'index').
   * @param string $backend '1' if the action is in the backend, '0' otherwise.
   */
  public static function dispatch_action_to_controller($c, $a, $backend) {
    $backend = ($backend == '1');
    $controller = empty($c) ? 'application' : $c;
    $action = empty($a) ? 'index' : $a;

    // Infer the controller's class.
    $controller_class = self::infer_controller_class($controller, $backend);

    // Create the controller and call the provided action on it.
    new $controller_class($action);
  }

  /**
   * Infer the controller class based on the controller name and the `backend`
   * parameter.
   * @param string $controller_name
   * @param bool $backend
   */
  private static function infer_controller_class($controller_name, $backend) {
    // Convert the `$controller_name` into an actual class name (from
    // 'blog_posts' to 'BlogPostsController'.
    $controller_class = ucwords(str_replace('_', ' ', $controller_name));
    $controller_class = str_replace(' ', '', $controller_class) . 'Controller';

    // Prepend 'Backend' to the controller name if the route starts with
    // 'backend'.
    if ($backend) {
      $controller_class = 'Backend' . $controller_class;
    }

    return $controller_class;
  }
}
?>
