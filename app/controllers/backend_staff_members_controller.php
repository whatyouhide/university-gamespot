<?php
class BackendStaffMembersController extends BackendController {
  /**
   * GET /admins
   * List all the 'backend users' of the website.
   */
  public function index() {
    $this->restrict_to_admins();

    $current_id = $this->current_user->id;
    $this->staff_members = User::staff_members_except($current_id);
    $this->render('staff_members/index');
  }

  /**
   * GET /staff_members/block?id=1
   * Block a staff member.
   */
  public function block() {
    $this->set_blocked_to($this->params['id'], true);
  }

  /**
   * GET /staff_members/unblock?id=1
   * Unblock a staff member.
   */
  public function unblock() {
    $this->set_blocked_to($this->params['id'], false);
  }

  /**
   * Block/unblock the user identified by $id after ensuring that the current
   * user is a admin, that there's a user with that $id and that that user is
   * not a regular user.
   * @param int|string $id
   * @param bool $is_blocked
   */
  private function set_blocked_to($id, $is_blocked) {
    $this->restrict_to_admins();

    $member = $this->safe_find('User', $id);
    $this->ensure_user_is_staff_member($member);

    $member->update(['blocked' => $is_blocked]);
    $notice = $is_blocked ? 'Successfully blocked.' : 'Successfully unblocked.';
    redirect('/backend/staff_members', ['notice' => $notice]);
  }

  /**
   * Ensure the given user is a staff member. If she's not, redirect back.
   * @param User $user
   */
  private function ensure_user_is_staff_member($user) {
    if ($user->is_regular()) {
      redirect('/backend/staff_members', [
        'error' => "That's a regular user, not a staff member."
      ]);
    }
  }

}
?>
