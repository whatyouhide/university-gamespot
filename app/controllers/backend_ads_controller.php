<?php
/**
 * This file contains the definition of the BackendAdsController class.
 */

/**
 * A controller to manage ads in the backend.
 * @package Gamespot
 * @subpackage Controllers
 */
class BackendAdsController extends BackendController {
  /**
   * {@inheritdoc}
   */
  protected static $before_filters = array(
    'restrict' => 'all'
  );

  /**
   * GET /ads
   * Display all the ads.
   */
  public function index() {
    $this->ads = Ad::all();
  }

  /**
   * GET /ads/destroy?id=1
   * Destroy an ad.
   */
  public function destroy() {
    $ad = $this->safe_find_from_id('Ad');
    $ad->destroy();
    redirect('/backend/ads/index', ['notice' => 'Ad destroyed successfully.']);
  }

  /**
   * <b>Filter</b>
   * Restrict the actions of this controller to a specific permission.
   */
  protected function restrict() {
    $this->restrict_to_permission('manage_ads');
  }
}
?>
