<?php
class AdsController extends Controller {
  // GET /ads/nuevo
  // Display the form which creates a new ad.
  public function nuevo() {
    function extract_name_attribute($arr) { return $arr['name']; }

    // We want a bunch of named arrays that look like 'game_name' =>
    // 'game_name'. This structure is suggested by the <select> tag.
    $consoles = array_map('extract_name_attribute', Console::all());
    $consoles = array_combine($consoles, $consoles);
    $games = array_map('extract_name_attribute', Game::all());
    $games = array_combine($games, $games);
    // TODO we're still missing an Accessory model
    // $accessories = array_map('extract_name_attribute', Accessory::all());
    // $accessories = array_combine($accessories, $accessories);
    $accessories = array();

    $this->render('ads/nuevo', array(
      'ad_type' => $_GET['type'],
      'console_names' => $consoles,
      'game_names' => $games,
      'accessory_names' => $accessories
    ));
  }

  // POST /ads/create
  // Create a new ad record in the db and then redirects to the user's profile.
  public function create() {
    Ad::create(array(
      'user_email' => $_SESSION['user']['email'],
      'created_at' => mysql_timestamp(),
      'price' => $_POST['price'],
      'description' => $_POST['description'],
      'city' => $_POST['city'],
      'console_name' => $_POST['console_name']
    ));

    $type = $_POST['ad_type'];
    $last_insert_id = Ad::$db->last_insert_id();

    $type_related_query = "INSERT
      INTO `{$type}_ads`(`ad_id`, `{$type}_name`)
      VALUES ('$last_insert_id', '{$_POST[$type . '_name']}')
    ";

    Ad::$db->query($type_related_query);

    redirect_with_data('/users/profile', array('flash_message' => 'Ad created'));
  }
}
?>
