<?php
/**
 * This file contains the definition of the BlogController class.
 */

namespace Controllers;

use Models\Post;
use Models\Tag;

/**
 * A controller for checking out the blog in the frontend.
 */
class BlogController extends Controller {
  /**
   * GET /blog
   * Display all the blog articles.
   */
  public function index() {
    $this->filtered = false;
    $this->posts = Post::published();
  }

  /**
   * GET /blog/post?id=1
   * Show a single post.
   */
  public function post() {
    $this->post = $this->safe_find_from_id('Post');
  }

  /**
   * GET /blog/by_tag?tag_name=1
   * Get a list of posts with a given tag.
   */
  public function by_tag() {
    $this->filtered = true;
    $this->tag = Tag::find_by_attribute('name', $this->params['tag_name']);
    $this->posts = Post::tagged_with($this->tag);
    $this->render('blog/index');
  }
}
?>
