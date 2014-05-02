<?php
class User extends Model {
  public static function where_attribute_is($attr, $val) {
    return parent::find_in_table_by_attribute('users', $attr, $val);
  }
}
?>
