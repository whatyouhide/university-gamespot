<?php
/**
 * This file contains the definition of the BackendController class.
 */

namespace Controllers;

use Models\Group;

/**
 * This controller is the base class for all the controllers in the backend of
 * the website, and provides some useful methods like:
 * - restrict access to backend resources based on the current user group
 * - automatically prepend template names with 'backend/'
 */
class BackendController extends Controller {
  /**
   * {@inheritdoc}
   * Also assign the 'backend' Smarty variable to true.
   */
  public function __construct($action) {
    parent::__construct($action);
    $this->smarty->assign('backend', true);
  }

  /**
   * {@inheritdoc}
   * Before rendering the template, prepend its name with 'backend/'.
   */
  public function render($template, $assigns = array()) {
    parent::render('backend/' . $template);
  }

  /**
   * Ensure a user has the right to do $permission. If not, redirect to the
   * backend's home page.
   */
  protected function restrict_to_permission($permission) {
    // First ensure the current user has access to the backend.
    $this->restrict_to_staff_members();

    // Return nothing if the user has the required permission.
    if ($this->current_user->can($permission)) {
      return;
    }

    // Build an error message.
    $array_of_groups = array_pluck(Group::with_permission($permission), 'name');
    $msg = "Need to be part of one of this groups: ";
    $msg .= implode(', ', $array_of_groups);

    redirect('/backend', ['error' => $msg]);
  }

  /**
   * {@inheritdoc}
   * Also get rid of 'backend_' to find the correct template.
   */
  protected function render_default_template() {
    $template_name = $this->controller_name()
      . '/'
      . $this->action_to_call;

    $this->render(str_replace('backend_', '', $template_name));
  }

  /**
   * Ensure the current user can see the backend.
   */
  protected function restrict_to_staff_members() {
    if ($this->current_user->can_access_backend()) { return; }
    redirect('/', ['error' => 'The backend is for staff members only']);
  }

  /**
   * Ensure the current user is an admin of the website. If not, redirect to the
   * backend's home page.
   */
  protected function restrict_to_admins() {
    if ($this->current_user->is_admin()) {
      return;
    }

    redirect('/backend', ['error' => 'You need to be an admin.']);
  }
}
?>
