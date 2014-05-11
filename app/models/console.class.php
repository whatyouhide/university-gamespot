<?php
class Console extends Model {
  public static function all() {
    return parent::all_the_records('consoles');
  }
}

Console::$db = new DB();
Console::$table_name = 'consoles';
?>
