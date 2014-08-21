<?php
class AdminController extends Controller {
  public function __construct($action) {
    parent::__construct($action);
    $this->smarty->assign('backend', true);
  }
}
?>
