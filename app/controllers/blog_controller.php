<?php
/**
 * This file contains the definition of the BlogController class.
 */

namespace Controllers;

use Models\Post;

/**
 * A controller for checking out the blog in the frontend.
 */
class BlogController extends Controller {
  /**
   * GET /blog
   * Display all the blog articles.
   */
  public function index() {
    $this->posts = Post::published();
  }

  /**
   * GET /blog/post?id=1
   * Show a single post.
   */
  public function post() {
    $this->post = $this->safe_find_from_id('Post');
  }
}
?>
