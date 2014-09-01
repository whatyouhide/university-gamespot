<?php
/**
 * This file contains the definition of the Game class.
 */

namespace Models;

/**
 * A videogame.
 */
class Game extends Model {
  /**
   * {@inheritdoc}
   */
  public static $table_name = 'games';

  /**
   * {@inheritdoc}
   * Also fetch the cover image of the game.
   */
  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->cover_image = $this->associated_cover_image();
    $this->console = $this->associated_console();
    $this->game_category = $this->associated_game_category();
  }

  /**
   * Update the cover image of this game to the given Upload instance. If the
   * $upload parameter is null or '', just remove the cover image of the game.
   * The previous cover image will be deleted anyways.
   * @param null|Upload $upload The new image for this record, or null to
   * destroy the image.
   */
  public function update_cover_image($upload) {
    $this->delete_cover_image();

    if (!empty($upload)) {
      $upload->update(['game_cover_id' => $this->id]);
      $this->cover_image = $upload;
    }
  }

  /**
   * {@inheritdoc}
   * Also destroy all the ads associated with this game.
   */
  public function destroy() {
    // Destroy all ads.
    $ads = Ad::associated_with_game($this->id);
    foreach ($ads as $ad) {
      $ad->destroy();
    }

    // Destroy this game.
    parent::destroy();
  }

  /**
   * {@inheritdoc}
   */
  public static function validate($attributes) {
    $validator = new Validator($attributes);

    $validator->must_not_be_empty('name');
    $validator->must_not_be_empty('software_house', 'Software house needed');
    $validator->must_not_be_empty('console_id');
    $validator->must_not_be_empty('category_id');

    return $validator->error_messages();
  }

  /**
   * Get the most recently added games.
   * @param int $limit How many games to retrieve.
   * @return array The most recently added games.
   */
  public static function recently_added($limit = 5) {
    return self::latest_by_attribute('created_at', $limit);
  }

  /**
   * Get the most recently released games.
   * @param int $limit How many games to retrieve.
   * @return array The most recently released games.
   */
  public static function newest($limit = 5) {
    return self::latest_by_attribute('release_date', $limit);
  }

  /**
   * Get the games with most ads.
   * @param int $limit How many games to retrieve.
   * @return array The games with most ads.
   */
  public static function with_most_ads($limit = 1) {
    $t = static::$table_name;

    $q = <<<SQL
SELECT `$t`.*, COUNT(*) ads_count
FROM `ads`
JOIN `$t` ON `ads`.`game_id` = `$t`.`id`
WHERE `ads`.`type` = 'game'
GROUP BY `$t`.`id`
ORDER BY ads_count DESC
LIMIT $limit
SQL;

    $result = self::new_instances_from_query($q);
    return ($limit == 1) ? $result[0] : $result;
  }

  /**
   * Get the cover image associated with this game.
   * @return Upload
   */
  private function associated_cover_image() {
    return Upload::find_by_attribute('game_cover_id', $this->id);
  }

  /**
   * Fetch the console associated with this game.
   * @return Console
   */
  private function associated_console() {
    return Console::find($this->console_id);
  }

  /**
   * Fetch all the categories associated with this game.
   * @return array
   */
  private function associated_game_category() {
    return GameCategory::find($this->game_category_id);
  }

  /**
   * Delete the image associated with this record. If there weren't any, do
   * nothing.
   */
  private function delete_cover_image() {
    if (!$this->cover_image) { return; }
    $this->cover_image->destroy();
    $this->cover_image = null;
  }
}
?>
