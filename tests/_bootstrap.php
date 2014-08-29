<?php
$GLOBALS['config'] = parse_ini_file('config.ini', true);

require_once(dirname(__FILE__) . '/../setup/defines.php');
require_once(dirname(__FILE__) . '/../setup/includes.php');

Common\Db::init();
?>
