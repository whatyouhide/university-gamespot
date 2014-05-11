<?php
class Ad extends Model {
  public static function create($attrs) {
    parent::create_record('ads', $attrs);
  }
}

Ad::$db = new DB();
Ad::$table_name = 'ads';
?>
