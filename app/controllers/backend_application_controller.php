<?php
/**
 * This file contains the definition of the Session class.
 */

namespace Controllers;

use Models\User;
use Models\Ad;
use Models\Visit;

/**
 * The controller for the backend home page.
 */
class BackendApplicationController extends BackendController {
  /**
   * {@inheritdoc}
   */
  protected static $before_filters = array();

  /**
   * GET /
   */
  public function index() {
    $this->regular_users_count = count(User::regular());
    $this->staff_members_count = count(User::staff_members());
    $this->ads_count = Ad::count();
    $this->number_of_visits = Visit::count();
    $this->unique_visitors_count = Visit::unique_visitors();

    $this->render('index');
  }
}
?>
