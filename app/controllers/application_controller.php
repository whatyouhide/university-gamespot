<?php
/**
 * This file contains the definition of the ApplicationController class.
 */

namespace Controllers;

use Models\Ad;
use Models\Game;
use Models\Accessory;

/**
 * The controller that responds to requests to `/`.
 */
class ApplicationController extends Controller {
  /**
   * GET /
   * The homepage of the website.
   */
  public function index() {
    $this->latest_ad = Ad::latest_by_attribute('published_at');
    $this->latest_game = Game::latest_by_attribute('created_at');
    $this->latest_accessory = Accessory::latest_by_attribute('created_at');
    $this->render('index');
  }
}
?>
