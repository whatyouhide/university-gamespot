<?php
/**
 * This file contains the definition of the Tag class.
 */

namespace Models;

/**
 * A post tag.
 */
class Tag extends Model {
  /**
   * {@inheritdoc}
   */
  public static $table_name = 'tags';

  /**
   * Given a tag name, return the id of that tag.
   * @param string $tag_name
   * @return int
   */
  public static function id_from_tag_name($tag_name) {
    $tag = self::find_by_attribute('name', $tag_name);
    return $tag->id;
  }
}
?>
