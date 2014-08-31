<?php
/**
 * This file contains the definition of the Error class.
 */

namespace Models;

use Common\Db;

/**
 * A visit on the website.
 */
class Error extends Model {
  /**
   * {@inheritdoc}
   */
  public static $table_name = 'errors';
}
?>
