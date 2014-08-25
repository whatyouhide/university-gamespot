<?php
/**
 * This file contains the definition of the BackendPostsController class.
 */

/**
 * A controller for managing blog posts in the backend.
 */
class BackendPostsController extends BackendController {
  /**
   * GET /posts
   * List all the posts in the website.
   */
  public function index() {
    $this->render('posts/index');
  }
}
?>
