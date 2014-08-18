<?php
class AdsController extends Controller {
  /**
   * GET /ads
   * List all the ads.
   */
  public function index() {
    $game_ads = Ad::where(['type' => 'game']);
    $accessory_ads = Ad::where(['type' => 'accessory']);

    $this->render('ads/index', [
      'game_ads' => $game_ads,
      'accessory_ads' => $accessory_ads
    ]);
  }

  /**
   * GET /ads/show
   *
   * Parameters:
   * - id: the id of the ad
   */
  public function show() {
    $ad = Ad::find($this->params['id']);

    if ($ad) {
      $this->render('ads/show', array('ad' => $ad));
    } else {
      $this->render_error(404);
    }
  }

  /**
   * GET /ads/nuevo
   * Display the form which creates a new ad.
   */
  public function nuevo() {
    $ad = Ad::create(['type' => $this->params['type']]);
    redirect("/ads/edit", array(), ['id' => $ad->id]);
  }

  /**
   * GET /ads/edit?id=1
   * Display the form which edits an ad.
   */
  public function edit() {
    $ad = Ad::find($this->params['id']);
    $consoles = $this->all_records_for_select('Console');
    $games = $this->all_records_for_select('Game');
    $accessories = $this->all_records_for_select('Accessory');

    $this->render('ads/edit', [
      'ad' => $ad,
      'console_names' => $consoles,
      'game_names' => $games,
      'accessory_names' => $accessories
    ]);
  }

  /**
   * POST /ads/create
   * Create a new ad and then redirect to the current user's profile.
   */
  public function update() {
    $type = $this->params['ad_type'];

    Ad::create([
      'city' => $this->params['city'],
      'description' => $this->params['description'],
      'price' => $this->params['price'],
      'type' => $type,
      'author_id' => $this->current_user->id,
      'console_id' => $this->params['console_id'],
      "{$type}_id" => $this->params[$type . '_id']
    ]);

    redirect('/users/profile', $flash);
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
   * Return an array to be used in a <select> tag containing the name of all the
   * records of `$model`.
   * @param string $model Instances of this model will be fetched (e.g. 'Game')
   * @return array An array in the form [name1 => name1, name2 => name2...]
   */
  private function all_records_for_select($model) {
    $all = $model::all();

    $ids = array_map(function ($r) { return $r->id; }, $all);
    $names = array_map(function ($r) { return $r->name; }, $all);

    return array_combine($ids, $names);
  }
}
?>
