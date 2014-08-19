<?php
class Ad extends Model {
  public static $table_name = 'ads';

  /**
   * {@inheritdoc}
   * Also fetch the game associated with this ad.
   */
  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->author = $this->associated_author();
    $this->console = $this->associated_console();

    if ($this->type == 'game') {
      $this->game = $this->associated_game();
    } else if ($this->type == 'accessory') {
      $this->accessory = $this->associated_accessory();
    }
  }

  /**
   * All the published ads.
   * @return array All the published ads.
   */
  public static function published() {
    $query = "SELECT * FROM `ads` WHERE `published` = '1'";
    return self::new_instances_from_query($query);
  }

  /**
   * Separate the given array of ads in a two-elements array with game ads and
   * accessory ads.
   * @param array $ads An array of ads.
   * @return array A two-element array with keys 'game_ads' and 'accessory_ads'.
   */
  public static function separate_game_and_accessory($ads) {
    $result = ['game_ads' => array(), 'accessory_ads' => array()];

    foreach ($ads as $ad) {
      if ($ad->type == 'game') {
        array_push($result['game_ads'], $ad);
      } else if ($ad->type == 'accessory') {
        array_push($result['accessory_ads'], $ad);
      }
    }

    return $result;
  }

  /**
   * {@inheritdoc}
   * Also insert a row in the `games_ads` or `accessories_ads` tables.
   */
  public static function create($attributes) {
    $type = $attributes['type'];

    // The name of the foreign key column, like `game_id`.
    $foreign_key_column = $type . '_id';

    // Remove the 'game_id' or 'accessory_id' member so that we can pass the
    // $attributes "as is" to the `create` function.
    if (isset($attributes[$foreign_key_column])) {
      $foreign_id = $attributes[$foreign_key_column];
      unset($attributes[$foreign_key_column]);
    }

    // Create the new ad.
    $new_ad = parent::create($attributes);

    // Update the join table if there's a foreign_key.
    if ($foreign_id) { $new_ad->update_join_table($foreign_id); }

    return $new_ad;
  }

  /**
   * {@inheritdoc}
   * Also update the join table if necessary.
   */
  public function update($attributes) {
    // The name of the foreign key column, like `game_id`.
    $foreign_key_column = $this->type . '_id';

    // Remove the 'game_id' or 'accessory_id' member so that we can pass the
    // $attributes "as is" to the `create` function.
    if (isset($attributes[$foreign_key_column])) {
      $foreign_id = $attributes[$foreign_key_column];
      unset($attributes[$foreign_key_column]);
    }

    // Create the new ad.
    parent::update($attributes);

    // Update the join table if there's a foreign_key.
    if (isset($foreign_id)) { $this->update_join_table($foreign_id); }

    return $this;
  }

  /**
   * Update the join table for the association with Game or Accessory.
   * @param int|string $foreign_id The id of the game/accessory associated with
   *        this ad.
   */
  public function update_join_table($foreign_id) {
    $type = $this->type;

    if ($type == 'game') {
      $join_table = 'games_ads';
      $foreign_key_column = 'game_id';
      $model = 'Game';
    } else if ($type == 'accessory') {
      $join_table = 'accessories_ads';
      $foreign_key_column = 'accessory_id';
      $model = 'Accessory';
    }

    $query = "INSERT INTO `$join_table`(`ad_id`, `$foreign_key_column`)"
      . " VALUES ('{$this->id}', '$foreign_id')"
      . " ON DUPLICATE KEY"
      . " UPDATE `ad_id`=VALUES(ad_id), `$foreign_key_column`=VALUES($foreign_key_column)";

    Db::query($query);

    $this->$type = $model::find($foreign_id);
  }

  /**
   * Find the console associated with this ad.
   * @return Console The console associated with this ad.
   */
  private function associated_console() {
    $q = "SELECT *"
      . " FROM `consoles`"
      . " WHERE `id` = '{$this->console_id}'";

    return self::instantiate_model_from_query('Console', $q);
  }

  /**
   * Find the game associated with this ad.
   * @return Game The game associated with this ad.
   */
  private function associated_game() {
    $q = "SELECT `games`.* "
      . "FROM `games` "
      . "INNER JOIN `games_ads` "
      . "ON `games`.`id` = `games_ads`.`game_id` "
      . "WHERE `games_ads`.`ad_id` = '{$this->id}'";

    return self::instantiate_model_from_query('Game', $q);
  }

  /**
   * Find the accessory associated with this ad.
   * @return Accessory The accessory associated with this ad.
   */
  private function associated_accessory() {
    $q = "SELECT `accessories`.* "
      . "FROM `accessories` "
      . "INNER JOIN `accessories_ads` "
      . "ON `accessories`.`id` = `accessories_ads`.`accessory_id` "
      . "WHERE `accessories_ads`.`ad_id` = '{$this->id}'";

    return self::instantiate_model_from_query('Accessory', $q);
  }

  /**
   * Find the author of this ad.
   * @return User The user who created this ad.
   */
  private function associated_author() {
    $q = "SELECT * "
      . "FROM `users` "
      . "WHERE `users`.`id` = '{$this->author_id}'";

    return self::instantiate_model_from_query('User', $q);
  }
}
?>
