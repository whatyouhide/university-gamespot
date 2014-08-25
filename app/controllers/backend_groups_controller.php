<?php
/**
 * This file contains the definition of the BackendGroupsController class.
 */

/**
 * A controller to manage groups in the backend.
 * @package Gamespot
 * @subpackage Controllers
 */
class BackendGroupsController extends BackendController {
  /**
   * {@inheritdoc}
   */
  protected static $before_filters = array(
    'restrict_to_admins' => 'all'
  );

  /**
   * GET /groups
   * Show all the groups.
   */
  public function index() {
    $this->groups = Group::all();
  }

  /**
   * POST /groups/create
   * Create a new group (based only on its name, all permissions will default to
   * false).
   */
  public function create() {
    $new_group = Group::create(['name' => $this->params['name']]);
    $this->render_plain($new_group->id);
  }

  /**
   * POST /groups/update?id=1
   * Update a single group and its permissions.
   */
  public function update() {
    $group = $this->safe_find_from_id('Group');
    $group->update($this->group_params());

    if (!$group->is_valid()) {
      $this->set_status_code(500)->render_plain($group->errors_as_string());
    }
  }

  /**
   * Return a subset of the request parameters used to update/create groups.
   * @return array
   */
  private function group_params() {
    return [
      'name' => $this->params['name'],
      'is_admin' => $this->boolean_param('is_admin'),
      'can_blog' => $this->boolean_param('can_blog'),
      'can_moderate_blog' => $this->boolean_param('can_moderate_blog'),
      'can_manage_products' => $this->boolean_param('can_manage_products'),
      'can_manage_ads' => $this->boolean_param('can_manage_ads'),
      'can_manage_support' => $this->boolean_param('can_manage_support'),
      'can_block_users' => $this->boolean_param('can_block_users')
    ];
  }

  /**
   * Return a boolean cast of a parameter that can be either the string 'true'
   * of 'false'.
   * @param string $param The name of the parameter.
   * @return bool
   */
  private function boolean_param($param) {
    return $this->params[$param] == 'true';
  }
}
?>
