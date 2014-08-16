<?php
class Console extends Model {
  public static $table_name = 'consoles';
  public static $key_column = 'name';
}

Console::$db = new DB();
?>
