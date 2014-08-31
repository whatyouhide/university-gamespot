<?php
/**
 * This file contains the definition of the Ad class.
 */

namespace Models;

use Common\Db;

/**
 * An ad.
 */
class Ad extends Model {
  /**
   * {@inheritdoc}
   */
  public static $table_name = 'ads';

  /**
   * {@inheritdoc}
   * Also fetch the game associated with this ad.
   */
  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->author = $this->associated_author();
    $this->console = $this->associated_console();
    $this->images = $this->associated_images();

    if ($this->type == 'game') {
      $this->game = $this->associated_game();
    } else if ($this->type == 'accessory') {
      $this->accessory = $this->associated_accessory();
    }
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
      $foreign_id = Db::escape($attributes[$foreign_key_column]);
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
   * this ad.
   */
  public function update_join_table($foreign_id) {
    $type = $this->type;

    if ($type == 'game') {
      $join_table = 'games_ads';
      $foreign_key_column = 'game_id';
      $model = 'Models\Game';
    } else if ($type == 'accessory') {
      $join_table = 'accessories_ads';
      $foreign_key_column = 'accessory_id';
      $model = 'Models\Accessory';
    }

    $query = "INSERT INTO `$join_table`(`ad_id`, `$foreign_key_column`)"
      . " VALUES ('{$this->id}', '$foreign_id')"
      . " ON DUPLICATE KEY"
      . " UPDATE `ad_id`=VALUES(ad_id), `$foreign_key_column`=VALUES($foreign_key_column)";

    Db::query($query);

    $this->$type = $model::find($foreign_id);
  }

  /**
   * Add an image to this ad.
   * @param Upload $image_upload The image to add to this ad.
   */
  public function add_image($image_upload) {
    $image_upload->update(['ad_id' => $this->id]);
    $this->images[] = $image_upload;
  }

  /**
   * Remove an image from this ad.
   * @param int|string $image_id The id of the image to remove.
   */
  public function remove_image($image_id) {
    $upload = Upload::find($image_id);
    $upload->destroy();
    $this->images = $this->associated_images();
  }

  /**
   * Tells whether an ad is a draft or has been published.
   * @return bool
   */
  public function is_draft() {
    return $this->published == '0';
  }

  /**
   * Return the cover image for this ad.
   * @return Upload
   */
  public function main_image() {
    return isset($this->images[0]) ? $this->images[0] : null;
  }

  /**
   * Return all the images except the main one.
   * @return array An array of `Upload` objects.
   */
  public function remaining_images() {
    if ($this->images && count($this->images) > 1) {
      return array_slice($this->images, 1);
    } else {
      return array();
    }
  }

  /**
   * Return all the published ads.
   * @return array
   */
  public static function published() {
    return self::where(['published' => '1']);
  }

  /**
   * Return the published ads which have a non blocked author.
   * @return array
   */
  public static function published_by_non_blocked_authors() {
    $by_legit_author = function ($ad) { return !$ad->author->is_blocked(); };
    return array_filter(self::published(), $by_legit_author);
  }

  /**
   * Return all the distinct cities for all the ads.
   * @return array
   */
  public static function all_cities() {
    $t = static::$table_name;
    return Db::array_from_one_column_query("SELECT DISTINCT `city` FROM `$t`");
  }

  /**
   * Return all the ads associated with a given game.
   * @param int|string $game_id The id of the game.
   * @return array
   */
  public static function associated_with_game($game_id) {
    $t = static::$table_name;
    $q = "SELECT `$t`.*"
      . " FROM `$t`"
      . " INNER JOIN `games_ads`"
      . " ON `games_ads`.`ad_id` = `$t`.`id`"
      . " WHERE `games_ads`.`game_id` = '$game_id'";

    return self::new_instances_from_query($q);
  }

  /**
   * Return all the ads associated with a given accessory.
   * @param int|string $accessory_id The id of the accessory.
   * @return array
   */
  public static function associated_with_accessory($accessory_id) {
    $t = static::$table_name;
    $q = "SELECT `$t`.*"
      . " FROM `$t`"
      . " INNER JOIN `accessories_ads`"
      . " ON `accessories_ads`.`ad_id` = `$t`.`id`"
      . " WHERE `accessories_ads`.`accessory_id` = '$accessory_id'";

    return self::new_instances_from_query($q);
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
  public static function create($attributes, $validate = true) {
    $type = $attributes['type'];

    // The name of the foreign key column, like `game_id`.
    $foreign_key_column = $type . '_id';

    // Remove the 'game_id' or 'accessory_id' member so that we can pass the
    // $attributes "as is" to the `create` function.
    if (isset($attributes[$foreign_key_column])) {
      $foreign_id = Db::escape($attributes[$foreign_key_column]);
      unset($attributes[$foreign_key_column]);
    }

    // Create the new ad.
    $new_ad = parent::create($attributes);

    // Update the join table if there's a foreign_key.
    if ($foreign_id) { $new_ad->update_join_table($foreign_id); }

    return $new_ad;
  }

  /**
   * The images associated with this ad.
   */
  private function associated_images() {
    return Upload::where(['ad_id' => $this->id]);
  }

  /**
   * Find the console associated with this ad.
   * @return Console The console associated with this ad.
   */
  private function associated_console() {
    return Console::find($this->console_id);
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
    return User::find($this->author_id);
  }
}
?>
