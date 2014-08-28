<?php
/**
 * This file contains the definition of the BackendUsersController class.
 */

namespace Controllers;

use Models\User;

/**
 * A controller to manage regular users in the backend.
 */
class BackendUsersController extends BackendController {
  /**
   * {@inheritdoc}
   */
  protected static $before_filters = array(
    'restrict' => 'all',
    'set_user_and_ensure_is_regular' => ['block', 'unblock']
  );

  /**
   * GET /users
   * List all <b>regular</b> users on the website.
   */
  public function index() {
    $this->users = User::regular();
  }

  /**
   * GET /users/block?id=1
   * Block a user.
   */
  public function block() {
    $this->user->update(['blocked' => true]);
    redirect('/backend/users', ['notice' => 'Successfully blocked.']);
  }

  /**
   * GET /users/unblock?id=1
   * Unblock a user.
   */
  public function unblock() {
    $this->user->update(['blocked' => false]);
    redirect('/backend/users', ['notice' => 'Successfully unblocked.']);
  }

  /**
   * <b>Filter</b>
   * Restrict the actions of this controller to a specific permission.
   */
  protected function restrict() {
    $this->restrict_to_permission('block_users');
  }

  /**
   * <b>Filter</b>
   * Set the `user` instance variable.
   */
  protected function set_user_and_ensure_is_regular() {
    $this->user = $this->safe_find_from_id('User');

    if ($this->user->is_regular()) { return; }
    redirect('/backend/users', ['error' => "Can't touch a non-regular user."]);
  }
}
?>
