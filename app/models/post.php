<?php
/**
 * This file contains the definition of the Post class.
 */

/**
 * A blog post.
 */
class Post extends Model {
  /**
   * {@inheritdoc}
   */
  public static $table_name = 'posts';

  /**
   * {@inheritdoc}
   * Also fetch associated models.
   */
  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->author = $this->associated_author();
  }

  /**
   * Return true if the post is published.
   * @return bool
   */
  public function is_published() {
    return $this->published == '1';
  }

  /**
   * Publish if unbpublished and unpublish if published.
   */
  public function toggle_published() {
    $params = array();
    $will_be_published = !$this->is_published();

    $params['published'] = $will_be_published;
    $params['published_at'] = $will_be_published ? Db::datetime() : null;

    $this->update($params);
  }

  /**
   * Scope the posts to the published ones.
   * @return array
   */
  public static function published() {
    return self::where(['published' => true]);
  }

  /**
   * {@inheritdoc}
   */
  protected static function validate($attributes) {
    $validator = new Validator($attributes);

    $validator->must_not_be_empty('title');
    $validator->must_not_be_empty('content');
    $validator->must_not_be_empty('excerpt');

    return $validator->error_messages();
  }

  /**
   * Fetch the author of this post.
   * @return User
   */
  private function associated_author() {
    return User::find($this->author_id);
  }
}
?>
