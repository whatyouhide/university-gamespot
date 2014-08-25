<?php
/**
 * This file contains the definition of the GameCategory class.
 */

/**
 * A cateogory of games.
 * @package Gamespot
 * @subpackage Models
 */
class GameCategory extends Model {
  /**
   * {@inheritdoc}
   */
  public static $table_name = 'game_categories';

  /**
   * {@inheritdoc}
   */
  public static function validate($attributes) {
    $validator = new Validator($attributes);
    $validator->must_not_be_empty('name');
    return $validator->error_messages();
  }
}
?>
