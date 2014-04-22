<?php
include ROOT . '/lib/smarty/libs/Smarty.class.php';

class GamespotSmarty extends Smarty {
  function __construct() {
    parent::__construct();

    $this->setTemplateDir(ROOT . '/app/views/');
    $this->setCompileDir(ROOT . '/templates_c/');
    $this->setConfigDir(ROOT . '/configs/');
    $this->setCacheDir(ROOT . '/cache/');

    $this->assign('site_name', SITE_NAME);
    $this->assign('site_root', SITE_ROOT);
    $this->assign('root', ROOT);

    $this->assign('controllers', SITE_ROOT . '/app/controllers');

    $this->assign('uploads', SITE_ROOT . '/public/uploads');
  }
}
?>
