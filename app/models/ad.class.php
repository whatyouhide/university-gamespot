<?php
class Ad extends Model {
  public static function create($attrs) {
    parent::create_record('ads', $attrs);
  }

  public static function all() {
    $all = parent::all_the_records('ads');
    $all_with_games = array();

    foreach ($all as $ad) {
      $ad['game'] = self::find_associated_game($ad['id']);
      array_push($all_with_games, $ad);
    }

    return $all_with_games;
  }

  public static function find_by_id($id) {
    $ad = parent::find_unique('ads', 'id', $id);

    if (!$ad) return null;

    $ad['game'] = self::find_associated_game($ad['id']);
    return $ad;
  }

  private static function find_associated_game($ad_id) {
    $q = "SELECT *
      FROM `game_ads`
      JOIN `games`
      ON `game_ads`.`game_name` = `games`.`name`
      WHERE `game_ads`.`ad_id` = $ad_id
    ";

    $result = self::$db->get_rows($q);
    $result = $result[0];
    return $result;
  }
}

Ad::$db = new DB();
Ad::$table_name = 'ads';
?>
