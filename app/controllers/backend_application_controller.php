<?php
class BackendApplicationController extends BackendController {
  public function index() {
    $this->restrict_to_staff_members();
    $this->render('index');
  }
}
?>
