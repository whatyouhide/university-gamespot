<?php
class Ad extends Model {
  public static $table_name = 'ads';
  public static $key_column = 'id';

  /**
   * {@inheritdoc}
   * Also fetch the game associated with this ad.
   */
  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->game = $this->associated_game();
  }

  /**
   * Find the game associated with this ad.
   * @return Game The game associated with this ad.
   */
  private function associated_game() {
    $q = "SELECT * "
      . "FROM `game_ads` "
      . "JOIN `games` "
      . "ON `game_ads`.`game_name` = `games`.`name` "
      . "WHERE `game_ads`.`ad_id` = {$this->id}";

    $game_attributes = static::$db->get_rows($q)[0];
    return new Game($game_attributes);
  }
}

Ad::$db = new DB();
?>
