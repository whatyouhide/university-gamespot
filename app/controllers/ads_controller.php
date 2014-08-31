<?php
/**
 * This file contains the definition of the AdsController class.
 */

namespace Controllers;

use Models\Accessory;
use Models\Ad;
use Models\Console;
use Models\Game;
use Models\Upload;

/**
 * A controller to manage ads on the frontend.
 */
class AdsController extends Controller {
  /**
   * {@inheritdoc}
   */
  protected static $before_filters = array(
    'set_models_for_selects' => ['index', 'filter'],
    'set_form_values' => ['index', 'filter']
  );

  /**
   * GET /ads
   * List all the ads.
   */
  public function index() {
    $all = Ad::published_by_non_blocked_authors();
    $this->set_game_and_acccessory_ads($all);
  }

  /**
   * GET /ads/filter
   * Filter ads.
   */
  public function filter() {
    $ads = Ad::filter_with_params($this->params);
    $this->set_game_and_acccessory_ads($ads);
    $this->render('ads/index');
  }

  /**
   * GET /ads/show?id=1
   */
  public function show() {
    $this->ad = $this->safe_find_from_id('Ad');

    if ($this->ad->author->is_blocked()) {
      redirect('/ads', ['error' => 'The author of this ad is blocked']);
    }
  }

  /**
   * GET /ads/nuevo
   * Create a new ad and redirect to the newly created ad's edit page.
   */
  public function nuevo() {
    $ad = Ad::create([
      'type' => $this->params['type'],
      'author_id' => $this->current_user->id
    ]);

    redirect("/ads/edit", array(), ['id' => $ad->id]);
  }

  /**
   * GET /ads/edit?id=1
   * Display the form which edits an ad.
   */
  public function edit() {
    $this->ad = $this->ad_protected_for_current_user($this->params['id']);

    $this->console_names = Console::all_for_select_with('name');
    $this->game_names = Game::all_for_select_with('name');
    $this->accessory_names = Accessory::all_for_select_with('name');
  }

  /**
   * POST /ads/update?id=1
   * Create a new ad and then redirect to the current user's profile.
   */
  public function update() {
    $ad = $this->ad_protected_for_current_user($this->params['id']);
    $type = $ad->type;

    $ad->update([
      'city' => $this->params['city'],
      'description' => $this->params['description'],
      'price' => $this->params['price'],
      'type' => $type,
      'author_id' => $this->current_user->id,
      'console_id' => $this->params['console_id'],
      "{$type}_id" => $this->params[$type . '_id'],
      'published' => $this->params['published']
    ]);

    redirect(
      '/ads/edit',
      ['notice' => 'Ad updated successfully'],
      ['id' => $ad->id]
    );
  }

  /**
   * GET /ads/destroy?id=1
   * Destroy an ad.
   */
  public function destroy() {
    $ad = $this->ad_protected_for_current_user($this->params['id']);
    $ad->destroy();
    redirect('/users/profile', ['notice' => 'Destroyed successfully.']);
  }

  /**
   * POST /ads/upload_image?id=1
   * Upload an image for an ad.
   * @internal Ajax
   */
  public function upload_image() {
    $ad = $this->ad_protected_for_current_user($this->params['id']);
    $upload = Upload::create_from_uploaded_file($_FILES['file']);
    $ad->add_image($upload);
    $this->no_content();
  }

  /**
   * GET /ads/remove_image?id=1&image_id=1
   * Remove an image from an ad.
   */
  public function remove_image() {
    $ad = $this->ad_protected_for_current_user($this->params['id']);
    $ad->remove_image($this->params['image_id']);
    redirect('/ads/edit', ['notice' => 'Image successfully removed.'], ['id' => $ad->id]);
  }

  /**
   * POST /ads/contact
   * Contact the owner of the ad via email, then redirect to the ad's page.
   */
  public function contact() {
    // Retrieve the ad from the params.
    $ad = Ad::find($this->params['ad_id']);

    // Send the email.
    $this->mailer->send([
      'from' => $this->email_for_contact(),
      'from_name' => $this->name_for_contact(),
      'to' => $ad->author->email,
      'subject' => 'Someone from gamespot.com contacted you',
      'body' => $this->params['message']
    ]);

    // Redirect back to the ads page.
    $flash = $this->mailer->sent_successfully() ?
      ['notice' => 'Sent successfully.'] : ['error' => 'There was an error'];

    redirect("/ads/show?id={$ad->id}", $flash);
  }

  /**
   * <b>Filter</b>
   * Set a bunch of instance variables for dealing with models in <select> tags.
   */
  protected function set_models_for_selects() {
    $this->consoles_for_select = Console::all_for_select_with('name', true);
    $this->games_for_select = Game::all_for_select_with('name', true);
    $this->accessories_for_select = Accessory::all_for_select_with('name', true);

    $all_cities = Ad::all_cities();
    $this->cities_for_select = ['' => ''] + array_combine($all_cities, $all_cities);
  }

  /**
   * <b>Filter</b>
   * Set some starting form values.
   */
  protected function set_form_values() {
    $this->starting_values = $this->params_with_defaults();
  }

  /**
   * Return a bunch of filtering parameters with default values where they're
   * not present.
   * @return array
   */
  private function params_with_defaults() {
    $pars = ['console', 'city', 'last-7-days', 'type', 'game', 'accessory', 'max-price'];

    return [
      'console' => isset($this->params['console']) ? $this->params['console'] : '',
      'city' => isset($this->params['city']) ? $this->params['city'] : '',
      'last-7-days' => isset($this->params['last-7-days']) ? $this->params['last-7-days'] : '',
      'type' => isset($this->params['type']) ? $this->params['type'] : '',
      'game' => isset($this->params['game']) ? $this->params['game'] : '',
      'accessory' => isset($this->params['accessory']) ? $this->params['accessory'] : '',
      'max-price' => isset($this->params['max-price']) ? $this->params['max-price'] : '0'
    ];
  }

  /**
   * Retrieve the sender's name from the form or the currently logged in user.
   * @return string The name of the sender of the email.
   */
  private function name_for_contact() {
    if ($this->current_user) {
      return $this->current_user->first_name . $this->current_user->last_name;
    } else {
      return $this->params['name'];
    }
  }

  /**
   * Retrieve the sender's email from the form or the currently logged in user.
   * @return string The email of the sender of the email.
   */
  private function email_for_contact() {
    if ($this->current_user) {
      return $this->current_user->email;
    } else {
      return $this->params['sender_email'];
    }
  }

  /**
   * Set the `game_ads` and `accessory` ads instance variables starting with an
   * array of ads.
   * @param array $ads
   */
  private function set_game_and_acccessory_ads($ads) {
    $separated = Ad::separate_game_and_accessory($ads);
    $this->game_ads = $separated['game_ads'];
    $this->accessory_ads = $separated['accessory_ads'];
  }

  /**
   * Find the ad identified by `$id`, but render a 403 Forbidden error if that
   * ad doesn't belong to the current user.
   * @param int|string $id The id that identifies the ad.
   * @return Ad The ad identified by `$id`.
   */
  private function ad_protected_for_current_user($id) {
    $ad = $this->safe_find('Ad', $id);

    if ($ad->author_id != $this->current_user->id) {
      $this->render_error('forbidden');
    } else {
      return $ad;
    }
  }
}
?>
