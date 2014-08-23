<?php
class BackendAdsController extends BackendController {
  /**
   * GET /ads
   * Display all the ads.
   */
  public function index() {
    $this->restrict_to_permission('manage_ads');
    $this->ads = Ad::all();

    $this->render('ads/index');
  }

  /**
   * GET /ads/destroy?id=1
   * Destroy an ad.
   */
  public function destroy() {
    $this->restrict_to_permission('manage_ads');
    $ad = Ad::find($this->params['id']);
    $ad->destroy();

    redirect('/backend/ads/index', ['notice' => 'Ad destroyed successfully.']);
  }
}
?>
