<?php
class ApplicationController extends Controller {
  /**
   * GET /
   * The homepage of the website.
   */
  public function index() {
    $this->render('index');
  }
}
?>
