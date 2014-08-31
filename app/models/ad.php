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
   * Filter all the ads based on a set of parameters (that aren't escaped yet).
   * @param array $params
   * @return array
   */
  public static function filter_with_params($params) {
    $params = self::sanitize_attributes($params);

    $conditions = array();

    // Filter by console.
    if (!empty($params['console'])) {
      $conditions[] = "`console_id` = '{$params['console']}'";
    }

    // Filter by game or accessory.
    if (!empty($params['type'])) {
      $conditions[] = "`type` = '{$params['type']}'";

      if ($params['type'] == 'game' && isset($params['game']) && !empty($params['game'])) {
        $conditions[] = "`game_id` = '{$params['game']}'";
      } else if ($params['type'] == 'accessory' && isset($params['accessory']) && !empty($params['accessory'])) {
        $conditions[] = "`accessory_id` = '{$params['accessory']}'";
      }
    }

    // Filter by city.
    if (!empty($params['city'])) {
      $conditions[] = "`city` = '{$params['city']}'";
    }

    // Filter by publication date.
    if (isset($params['last-7-days']) && $params['last-7-days'] == 'true') {
      $conditions[] = "`published_at` >= CURDATE() - INTERVAL 7 DAY";
    }

    // Filter by price.
    $max_price = intval($params['max-price']);
    if ($max_price > 0) {
      $conditions[] = "`price` <= '$max_price'";
    }

    // Build the query.
    $t = static::$table_name;
    $q = "SELECT * FROM `$t` " . static::where_clause_from_conditions($conditions);

    return self::new_instances_from_query($q);
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
    return self::where(['game_id' => $game_id]);
  }

  /**
   * Return all the ads associated with a given accessory.
   * @param int|string $accessory_id The id of the accessory.
   * @return array
   */
  public static function associated_with_accessory($accessory_id) {
    return self::where(['accessory_id' => $accessory_id]);
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
    return Game::find($this->game_id);
  }

  /**
   * Find the accessory associated with this ad.
   * @return Accessory The accessory associated with this ad.
   */
  private function associated_accessory() {
    return Accessory::find($this->accessory_id);
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
