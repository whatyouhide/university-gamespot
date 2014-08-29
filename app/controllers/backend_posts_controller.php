<?php
/**
 * This file contains the definition of the BackendPostsController class.
 */

namespace Controllers;

use Models\Post;
use Models\Tag;

/**
 * A controller for managing blog posts in the backend.
 */
class BackendPostsController extends BackendController {
  /**
   * {@inheritdoc}
   */
  protected static $before_filters = array(
    'restrict' => 'all',
    'set_post' => ['edit', 'toggle_published', 'update', 'destroy'],
    'restrict_to_author' => ['edit', 'toggle_published', 'update', 'destroy']
  );

  /**
   * GET /posts
   * List all the posts in the website.
   */
  public function index() {
    $this->posts = Post::all();
  }

  /**
   * GET /posts/nuevo
   * Create a new post, save it to the database and redirect to the edit page of
   * the new post.
   */
  public function nuevo() {
    // Create a new post without validating.
    $new_post = Post::create(['author_id' => $this->current_user->id], false);
    redirect('/backend/posts/edit', [], ['id' => $new_post->id]);
  }

  /**
   * GET /posts/edit?id=1
   * Edit a post.
   */
  public function edit() {
    $this->tags = Tag::all();
  }

  /**
   * POST /posts/update?id=1
   * Update a post.
   */
  public function update() {
    $this->post->update($this->post_params());

    if ($this->post->is_valid()) {
      $flash = ['notice' => 'Saved Successfully'];
    } else {
      $flash = ['error' => $this->post->errors_as_string()];
    }

    redirect('/backend/posts/edit', $flash, ['id' => $this->post->id]);
  }

  /**
   * GET /posts/destroy?id=1
   * Destroy a post.
   */
  public function destroy() {
    $this->post->destroy();
    redirect('/backend/posts', ['notice' => 'Successfully destroyed']);
  }

  /**
   * POST /posts/toggle_published?id=1
   * Publish an unbpublished post and unpublish a published one.
   */
  public function toggle_published() {
    $will_be_published = !$this->post->is_published();
    $this->post->toggle_published();
    redirect(
      '/backend/posts/edit',
      ['notice' => $will_be_published ? 'Published' : 'Unpublished'],
      ['id' => $this->post->id]
    );
  }

  /**
   * <b>Filter</b>
   * Restrict the actions of this controller to users which have a specific
   * permission.
   */
  protected function restrict() {
    $this->restrict_to_permission('blog');
  }

  /**
   * <b>Filter</b>
   * Ensure the target post belongs to the current user.
   */
  protected function restrict_to_author() {
    if ($this->post->author_id != $this->current_user->id) {
      forbidden();
    }
  }

  /**
   * <b>Filter</b>
   * Set the `post` instance variable.
   */
  protected function set_post() {
    $this->post = $this->safe_find_from_id('Post');
  }

  /**
   * Return an array of parameters to pass to Post::update().
   * @return array
   */
  private function post_params() {
    return [
      'title' => $this->params['title'],
      'excerpt' => $this->params['excerpt'],
      'content' => $this->params['content'],
      'tags' => $this->params['tags']
    ];
  }
}
?>
