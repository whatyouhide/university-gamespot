<?php
class Model {
  static $db;
  static $table_name;

  public static function find_in_table_by_attribute($table_name, $attr, $val) {
    $q = "SELECT * FROM `" . $table_name .  "` WHERE `$attr` = '$val'";
    return self::$db->get_rows($q);
  }
}

Model::$db = new DB();
?>
