<?php
class BackendUsersController extends BackendController {
  /**
   * GET /users
   * List all <b>regular</b> users on the website.
   */
  public function index() {
    $this->restrict_to_permission('block_users');

    $this->users = User::regular();
    $this->render('users/index');
  }

  /**
   * GET /users/block?id=1
   * Block a user.
   */
  public function block() {
    $this->restrict_to_permission('block_users');

    $user = $this->safe_find_user();
    $this->ensure_user_is_regular($user);

    $user->update(['blocked' => true]);
    redirect('/backend/users', ['notice' => 'Successfully blocked.']);
  }

  /**
   * GET /users/unblock?id=1
   * Unblock a user.
   */
  public function unblock() {
    $this->restrict_to_permission('block_users');

    $user = $this->safe_find_user();
    $this->ensure_user_is_regular($user);

    $user->update(['blocked' => false]);
    redirect('/backend/users', ['notice' => 'Successfully unblocked.']);
  }

  /**
   * Block the action and redirect with a flash error if the target user isn't a
   * regular user.
   * @param $user
   */
  private function ensure_user_is_regular($user) {
    if ($user->is_regular()) { return; }
    redirect('/backend/users', ['error' => "Can't touch a non-regular user."]);
  }

  /**
   * Find a user or render a 404 error if none is found.
   * @return User
   */
  private function safe_find_user() {
    $user = User::find($this->params['id']);
    if (is_null($user)) {
      not_found();
    } else {
      return $user;
    }
  }
}
?>
