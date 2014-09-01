<?php
/**
 * This file contains the definition of the AccessoryNotification class.
 */

namespace Models;

/**
 * A notification subscription which ties up a user and an accessory.
 */
class AccessoryNotification extends Model {
  public static $table_name = 'accessory_notifications';

  /**
   * Create or update.
   * @param int $user_id
   * @param int $accessory_id
   * @return bool True if a new record is created, false otherwise.
   */
  public static function tie_up_user_and_accessory($user_id, $accessory_id) {
    $existing = self::where(['user_id' => $user_id, 'accessory_id' => $accessory_id]);

    if (empty($existing)) {
      self::create(['user_id' => $user_id, 'accessory_id' => $accessory_id]);
      return true;
    } else {
      return false;
    }
  }

  /**
   * Return all users subscribed to $accessory.
   * @param Accessory $accessory
   * @return array
   */
  public static function emails_of_users_subscribed_to($accessory) {
    $user_ids = array_pluck(self::where(['accessory_id' => $accessory->id]), 'user_id');
    return User::emails_of_ids($user_ids);
  }
}
?>
