<?php
/**
 * @package Gamespot
 * @subpackage Models
 */
class Game extends Model {
  public static $table_name = 'games';

  /**
   * {@inheritdoc}
   * Also fetch the cover image of the game.
   */
  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->cover_image = $this->associated_cover_image();
    $this->console = $this->associated_console();
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
   * Get the most recently added games.
   * @param int $limit How many games to retrieve.
   * @return array The most recently added games.
   */
  public static function recently_added($limit = 5) {
    $t = static::$table_name;
    $q = "SELECT * FROM `$t` ORDER BY `created_at` DESC LIMIT $limit";
    return self::new_instances_from_query($q);
  }

  /**
   * Get the most recently released games.
   * @param int $limit How many games to retrieve.
   * @return array The most recently released games.
   */
  public static function newest($limit = 5) {
    $t = static::$table_name;
    $q = "SELECT * FROM `$t` ORDER BY `release_date` DESC LIMIT $limit";
    return self::new_instances_from_query($q);
  }

  /**
   * Get the games with most ads.
   * @param int $limit How many games to retrieve.
   * @return array The games with most ads.
   */
  public static function with_most_ads($limit = 5) {
    $t = static::$table_name;
    $q = "SELECT
      `ads`.`id` AS `ad_id`, `$t`.*,
      COUNT(*) `number_of_ads`
      FROM `games_ads`
      JOIN `$t` ON `games_ads`.`game_id` = `games`.`id`
      JOIN `ads` ON `games_ads`.`ad_id` = `ads`.`id`
      GROUP BY `$t`.`name`
      ORDER BY `number_of_ads` DESC
      LIMIT $limit
    ";
    return self::new_instances_from_query($q);
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
