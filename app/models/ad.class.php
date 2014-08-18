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

    if ($this->type == 'game') {
      $this->game = $this->associated_game();
    } else if ($this->type == 'accessory') {
      $this->accessory = $this->associated_accessory();
    }
  }

  /**
   * {@inheritdoc}
   * Also insert a row in the `games_ads` or `accessories_ads` tables.
   */
  public static function create($attributes) {
    $new_ad = parent::create($attributes);
    var_dump($new_ad);

    if (!isset($attributes[$foreign_id_name])) { return $new_ad; }

    $type = $attributes['type'];
    $foreign_id_name = $type . '_id';

    $foreign_id = $attributes[$foreign_id_name];
    unset($attributes[$foreign_id_name]);

    if ($type == 'game') {
      $join_table = 'games_ads';
    } else if ($type == 'accessory') {
      $join_table = 'accessories_ads';
    }

    $q = "INSERT "
      . "INTO `$join_table`(`ad_id`, `$foreign_id_name`)"
      . "VALUES ('{$new_ad->id}', '$foreign_id')";


    Db::query($q);
    return $new_ad;
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
