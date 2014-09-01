<?php
/**
 * This file contains the definition of the Router class.
 */

namespace Common;

use Http\Request;

/**
 * The singleton class that handles routing in the application.
 */
class Router {
  /**
   * @var array The routes that need authentication.
   */
  private static $autheticated_routes = array(
    '\/users\/profile',
    '\/users\/settings',
    '\/users\/save_settings',
    '\/users\/change_password',
    '\/users\/upload_profile_picture',
    '\/users\/delete_profile_picture',
    'subscribe',
    '\/support',
    '^\/backend'
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
   * @param string $backend True if the action is in the backend, false otherwise.
   */
  public static function dispatch_action_to_controller($c, $a, $backend) {
    self::authenticate_route(Request::path());

    $controller = empty($c) ? 'application' : $c;
    $action = empty($a) ? 'index' : $a;

    // Infer the controller's class.
    $controller_class = self::infer_controller_class($controller, $backend);

    self::dispatch_or_not_found($controller_class, $action);
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

    // Namespace this bitch.
    $controller_class = 'Controllers\\' . $controller_class;

    return $controller_class;
  }

  /**
   * Protect a given route with authentication.
   * If the route doesn't require authentication, do nothing.
   * @param string $url The route to protect.
   */
  private static function authenticate_route($url) {
    // If the url needs authentication and there's no authenticated user,
    // redirect to the login page.
    if (self::needs_authentication($url) && !Session::user()) {
      Session::set_referer_to($url);
      redirect('/users/sign_in', ['notice' => 'You need to be authenticated']);
    }
  }

  /**
   * Return true if the given url needs authentication.
   * @param string $url
   * @return mixed
   */
  private static function needs_authentication($url) {
    $filter = function ($regex) use ($url) {
      return preg_match('/' . $regex . '/', $url);
    };

    return count(array_filter(self::$autheticated_routes, $filter)) > 0;
  }

  /**
   * Check if the controller exists and if it does dispatch the action.
   * If it doesn't, render a 404 error.
   * @param string $controller_class
   * @param string $action
   */
  private static function dispatch_or_not_found($controller_class, $action) {
    if (class_exists($controller_class)) {
      $controller = new $controller_class($action);
      $controller->dispatch();
    } else {
      not_found();
    }
  }
}
?>
