<?php
/**
 * This file contains the definition of the AdsController class.
 */

/**
 * A controller to manage ads on the frontend.
 */
class AdsController extends Controller {
  /**
   * GET /ads
   * List all the ads.
   */
  public function index() {
    $all = Ad::published_by_non_blocked_authors();
    $separated = Ad::separate_game_and_accessory($all);
    $this->game_ads = $separated['game_ads'];
    $this->accessory_ads = $separated['accessory_ads'];
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
