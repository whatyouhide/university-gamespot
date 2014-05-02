<?php
class ApplicationController {
  function __construct() {
    $this->smarty = new GamespotSmarty();
  }

  public function index() {
    $this->smarty->display('index.tpl');
  }
}
?>
