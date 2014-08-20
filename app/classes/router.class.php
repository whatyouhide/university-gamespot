<?php
/**
 * The singleton class that handles routing in the application.
 * @package Gamespot
 * @subpackage Common
 */
class Router {
  /**
   * @var array The routes that need authentication.
   */
  private static $autheticated_routes = array(
    '\/users\/profile' => 'regular',
    '\/users\/settings' => 'regular',
    '\/users\/save_settings' => 'regular',
    '\/users\/change_password' => 'regular',
    '\/users\/upload_profile_picture' => 'regular',
    '\/users\/delete_profile_picture' => 'regular'
  );

  /**
   * Dispatch an action to a controller based on the parameters that .htaccess
   * set in the $_GET array.
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
    self::authenticate_route(Request::path());

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

  /**
   * Protect a given route with authentication.
   * If the route doesn't require authentication, simply return nothing.
   * @param string $url The route to protect.
   */
  private static function authenticate_route($url) {
    $user_type = self::find_route_in_authenticated($url);

    // If no urls matched, go ahead with the normal course.
    if (!$user_type) return;

    $current_user = Session::user();

    if (!$current_user) {
      Session::set_referer_to($url);
      redirect('/users/sign_in', ['notice' => 'You need to be authenticated.']);
    }
  }

  /**
   * Find if the given `$url` matches on of the urls defined in the
   * `$authenticated_routes` array. If it matches, return the value of the url
   * in the routes array, otherwise return null.
   * @param string $url
   * @return mixed
   */
  private static function find_route_in_authenticated($url) {
    foreach (self::$autheticated_routes as $route_regex => $user_type) {
      if (preg_match('/' . $route_regex . '/', $url)) {
        return $user_type;
      }
    }

    return null;
  }
}
?>
