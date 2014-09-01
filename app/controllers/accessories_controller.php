<?php
/**
 * This file contains the definition of the AccessoriesController class.
 */

namespace Controllers;

use \Models\Accessory;
use \Models\AccessoryNotification;

/**
 * A controller to see accessories.
 */
class AccessoriesController extends Controller {
  /**
   * GET /accessories
   * List all the accessories.
   */
  public function index() {
    $this->accessories = Accessory::all();
    $this->accessory_with_most_ads = Accessory::with_most_ads();
  }

  /**
   * GET /accessories/subscribe?id=1
   * Subscribe to receive updates about this accessory and related ads.
   */
  public function subscribe() {
    $accessory_id = $this->params['id'];
    $created = AccessoryNotification::tie_up_user_and_accessory(
      $this->current_user->id,
      $accessory_id
    );

    if ($created) {
      $flash = ['info' => "You'll receive updates when ads about this accessory are published"];
    } else {
      $flash = ['info' => "You're already subscribed to this accessory"];
    }

    redirect('/accessories', $flash);
  }
}
?>
