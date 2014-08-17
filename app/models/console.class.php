<?php
class Console extends Model {
  public static $table_name = 'consoles';
}

Console::$db = new DB();
?>
