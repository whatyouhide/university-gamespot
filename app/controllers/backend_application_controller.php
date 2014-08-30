<?php
/**
 * This file contains the definition of the Session class.
 */

namespace Controllers;

use Models\User;
use Models\Ad;

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
    $this->regularUsersCount = count(User::regular());
    $this->staffMembersCount = count(User::staff_members());
    $this->adsCount = Ad::count();
    $this->render('index');
  }
}
?>
