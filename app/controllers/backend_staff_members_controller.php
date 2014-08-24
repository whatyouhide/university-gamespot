<?php
/**
 * This file contains the definition of the BackendStaffMembersController class.
 */

/**
 * A controller for the members of the staff to allow admins to
 * create/block/unblock them.
 */
class BackendStaffMembersController extends BackendController {
  /**
   * GET /staff_members
   * List all the 'backend users' of the website.
   */
  public function index() {
    $this->restrict_to_admins();

    $current_id = $this->current_user->id;
    $this->staff_members = User::staff_members_except($current_id);
    $this->groups = Group::all();
    $this->render('staff_members/index');
  }

  /**
   * GET /staff_members/nuevo
   * Display the form for a new staff member.
   */
  public function nuevo() {
    $this->restrict_to_admins();

    $this->groups = Group::all();
    $this->groups_for_select = $this->all_groups_for_select();
    $this->render('staff_members/nuevo');
  }

  /**
   * POST /staff_members/create
   * Create a new staff members.
   */
  public function create() {
    $this->restrict_to_admins();

    $rand_password = User::random_password();
    $new_staff_member = User::create([
      'confirmed' => true,
      'email' => $this->params['email'],
      'first_name' => $this->params['first_name'],
      'last_name' => $this->params['last_name'],
      'password' => $rand_password,
      'group_id' => $this->params['group_id']
    ]);

    if ($new_staff_member->is_valid()) {
      $this->contact_new_staff_member($new_staff_member, $rand_password);
      redirect('/backend/staff_members', ['notice' => 'Successfully created.']);
    } else {
      redirect('/backend/staff_members/nuevo', [
        'error' => $new_staff_member->errors_as_string()
      ]);
    }
  }

  /**
   * GET /staff_members/change_group?id=1
   * POST /staff_members/change_group?id=1
   * When it's a GET, render the form to change the user's group, when it's a
   * POST actually change it.
   */
  public function change_group() {
    $this->member = $this->safe_find('User', $this->params['id']);
    $this->ensure_user_is_staff_member($this->member);

    if ($this->request->is_get()) {
      $this->change_group_get();
    } else if ($this->request->is_post()) {
      $this->change_group_post();
    }
  }

  /**
   * GET /staff_members/block?id=1
   * Block a staff member.
   */
  public function block() {
    $this->restrict_to_admins();

    $this->set_blocked_to($this->params['id'], true);
  }

  /**
   * GET /staff_members/unblock?id=1
   * Unblock a staff member.
   */
  public function unblock() {
    $this->restrict_to_admins();

    $this->set_blocked_to($this->params['id'], false);
  }

  /**
   * GET /staff_members/destroy?id=1
   * Remove a staff member.
   */
  public function destroy() {
    $this->restrict_to_admins();

    $member = $this->safe_find('User', $this->params['id']);
    $this->ensure_user_is_staff_member($member);
    $member->destroy();

    redirect('/backend/staff_members', ['notice' => 'Destroyed successfully']);
  }

  /**
   * Display the form for changing a user's group.
   */
  private function change_group_get() {
    $this->groups = Group::all();
    $this->groups_for_select = $this->all_groups_for_select();
    $this->render('staff_members/change_group');
  }

  /**
   * Actually change the group of a staff member.
   */
  private function change_group_post() {
    $this->member->update(['group_id' => $this->params['group_id']]);
    redirect('/backend/staff_members', [
      'notice' => 'Group changed successfully'
    ]);
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

  /**
   * Return a <select>-friendly array of groups (id => name).
   * @return array
   */
  private function all_groups_for_select() {
    $all = Group::all();
    return array_combine(
      array_pluck($all, 'id'),
      array_pluck($all, 'name')
    );
  }

  /**
   * Contact a new staff member after she's been added. This also sends her her
   * new password (she can change it later).
   */
  public function contact_new_staff_member($member, $password) {
    $message = $this->render_as_string('mails/new_staff_member', [
      'staff_member' => $member,
      'password' => $password
    ]);

    $this->mailer->send([
      'from' => 'admins@gamespot.com',
      'from_name' => 'Gamespot admins',
      'to' => $member->email,
      'subject' => "You are part of the Gamespot staff",
      'body' => $message,
      'is_html' => true
    ]);
  }
}
?>
