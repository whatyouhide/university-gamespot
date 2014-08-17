<?php
class Ad extends Model {
  public static $table_name = 'ads';

  /**
   * {@inheritdoc}
   * Also fetch the game associated with this ad.
   */
  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->game = $this->associated_game();
    $this->author = $this->associated_author();
  }

  /**
   * {@inheritdoc}
   * Also insert a row in the `games_ads` or `accessories_ads` tables.
   */
  public static function create($attributes) {
    $type = $attributes['type'];
    $foreign_id_name = $type . '_id';

    $foreign_id = $attributes[$foreign_id_name];
    unset($attributes[$foreign_id_name]);

    if ($type == 'game') {
      $join_table = 'games_ads';
    } else if ($type == 'accessory') {
      $join_table = 'accessories_ads';
    }

    $new_ad = parent::create($attributes);
    $q = "INSERT "
      . "INTO `$join_table`(`ad_id`, `$foreign_id_name`)"
      . "VALUES ('{$new_ad->id}', '$foreign_id')";

    static::$db->query($q);
  }

  /**
   * Find the game associated with this ad.
   * @return Game The game associated with this ad.
   */
  private function associated_game() {
    $q = "SELECT `games`.* "
      . "FROM `games` "
      . "INNER JOIN `games_ads` "
      . "ON `games`.`id` = `games_ads`.`game_id`"
      . "WHERE `games_ads`.`ad_id` = '{$this->id}'";

    return self::instantiate_model_from_query('Game', $q);
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

Ad::$db = new DB();
?>
