<?php
/**
 * This file contains the definition of the GameNotification class.
 */

namespace Models;

/**
 * A notification subscription which ties up a user and a game.
 */
class GameNotification extends Model {
  /**
   * {@inheritdoc}
   */
  public static $table_name = 'game_notifications';

  /**
   * Create or update.
   * @param int $user_id
   * @param int $game_id
   * @return bool True if a new record is created, false otherwise.
   */
  public static function tie_up_user_and_game($user_id, $game_id) {
    $existing = self::where(['user_id' => $user_id, 'game_id' => $game_id]);

    if (empty($existing)) {
      self::create(['user_id' => $user_id, 'game_id' => $game_id]);
      return true;
    } else {
      return false;
    }
  }

  /**
   * Return all users subscribed to $game.
   * @param Game $game
   * @return array
   */
  public static function emails_of_users_subscribed_to($game) {
    $user_ids = array_pluck(self::where(['game_id' => $game->id]), 'user_id');
    return User::emails_of_ids($user_ids);
  }
}
?>
