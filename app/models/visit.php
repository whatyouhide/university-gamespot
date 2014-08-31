<?php
/**
 * This file contains the definition of the Visit class.
 */

namespace Models;

use Common\Db;

/**
 * A visit on the website.
 */
class Visit extends Model {
  /**
   * {@inheritdoc}
   */
  public static $table_name = 'visits';

  /**
   * Increment the count of this visit.
   */
  public function increment_count() {
    $t = static::$table_name;
    $q = "UPDATE `$t` SET `count` = `count` + 1 WHERE `id` = '{$this->id}'";
    Db::query($q);
  }

  /**
   * Increment the visit for the current path+IP couple, otherwise create a new
   * one.
   * @param string $url
   * @param string $ip
   */
  public static function increment_or_create($url, $ip) {
    $visit = self::find_by_url_and_ip($url, $ip);

    if (is_null($visit)) {
      self::create(['url' => $url, 'ip' => $ip]);
    } else {
      $visit->increment_count();
    }
  }

  /**
   * Return the number of unique visitors.
   * @return int
   */
  public static function unique_visitors() {
    $t = static::$table_name;
    $q = "SELECT COUNT(DISTINCT `ip`) FROM `$t`";
    return Db::number_from_query($q);
  }

  /**
   * {@inheritdoc}
   */
  public static function count() {
    $t = static::$table_name;
    $q = "SELECT SUM(`count`) FROM `$t`";
    return Db::number_from_query($q);
  }

  /**
   * Find a unique visit by the 'url' and 'ip' attributes.
   * @param string $url
   * @param string $ip
   * @return Visit
   */
  private static function find_by_url_and_ip($url, $ip) {
    $res = self::where(['url' => $url, 'ip' => $ip]);

    if (empty($res)) {
      return null;
    } else {
      return $res[0];
    }
  }
}
?>
