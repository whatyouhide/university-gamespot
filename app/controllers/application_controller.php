<?php
/**
 * This file contains the definition of the ApplicationController class.
 */

/**
 * The controller that responds to requests to `/`.
 * @package Gamespot
 * @subpackage Controllers
 */
class ApplicationController extends Controller {
  /**
   * GET /
   * The homepage of the website.
   */
  public function index() {
    $this->render('index');
  }
}
?>
