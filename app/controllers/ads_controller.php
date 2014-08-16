<?php
class AdsController extends Controller {
  /**
   * GET /ads
   * List all the ads.
   */
  public function index() {
    $ads = Ad::all();
    $this->render('ads/index', array('ads' => $ads));
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
    $consoles = $this->model_names_for_select('Console');
    $games = $this->model_names_for_select('Game');

    // TODO we're still missing an Accessory model
    $accessories = array();

    $this->render('ads/nuevo', array(
      'ad_type' => $this->params['type'],
      'console_names' => $consoles,
      'game_names' => $games,
      'accessory_names' => $accessories
    ));
  }

  /**
   * POST /ads/create
   * Create a new ad and then redirect to the current user's profile.
   */
  public function create() {
    Ad::create([
      'user_email' => $this->current_user['email'],
      'created_at' => mysql_timestamp(),
      'price' => $this->params['price'],
      'description' => $this->params['description'],
      'city' => $this->params['city'],
      'console_name' => $this->params['console_name']
    ]);

    $type = $this->params['ad_type'];
    $last_insert_id = Ad::$db->last_insert_id();

    $type_related_query = "INSERT
      INTO `{$type}_ads`(`ad_id`, `{$type}_name`)
      VALUES ('$last_insert_id', '{$_POST[$type . '_name']}')
    ";

    Ad::$db->query($type_related_query);

    redirect('/users/profile', ['notice' => 'Ad created successfully.']);
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
      'to' => $ad->user_email,
      'subject' => 'Someone from gamespot.com contacted you',
      'body' => $this->params['message']
    ]);

    // Redirect back to the ads page.
    $flash = $this->mailer->sent_successfully() ?
      ['notice' => 'Sent successfully.'] : ['error' => 'There was an error'];

    redirect( "/ads/show?id={$ad['id']}", $flash);
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
  private function model_names_for_select($model) {
    $extract_name = function ($record) { return $record->name; };
    $names = array_map($extract_name, $model::all());
    return array_combine($names, $names);
  }
}
?>
