<?php
class AdminController extends Controller {
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
    // Return nothing if the user has the required permission.
    if ($this->current_user->can($permission)) { return; }

    // Build an error message.
    $array_of_groups = array_pluck(Group::with_permission($permission), 'name');
    $msg = "Need to be part of one of this groups: ";
    $msg .= implode(', ', $array_of_groups);

    redirect('/backend', ['error' => $msg]);
  }

  /**
   * {@inheritdoc}
   * Also change 'backend' => 'backend_' so that the final name will be
   * 'backend_consoles'.
   */
  protected function controller_name() {
    $lowered = parent::controller_name();
    return str_replace('backend', 'backend_', $lowered);
  }
}
?>
