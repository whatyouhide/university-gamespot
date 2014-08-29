<?php
/**
 * This file contains the definition of the Post class.
 */

namespace Models;

use Common\Db;
use Models\Tag;

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
    $this->tags = $this->associated_tags();
  }

  /**
   * {@inheritdoc}
   * Also set the post tags separately.
   */
  public function update($attributes) {
    if (isset($attributes['tags'])) {
      $tag_names = $attributes['tags'];
      unset($attributes['tags']);
    }

    parent::update($attributes);

    if (!$this->is_valid()) { return $this; }

    if (isset($tag_names)) {
      $tag_ids = array_map('\Models\Tag::id_from_tag_name', $tag_names);
      $this->set_tags_to($tag_ids);
    }
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
   * Set the tags of this post to the given list of tags.
   * @param array $tag_ids
   */
  private function set_tags_to($tag_ids) {
    // First let's remove all the tags from this post, then add all the tags in
    // the $tag_ids array.
    $this->remove_all_tags();
    array_walk($tag_ids, [$this, 'add_tag']);
  }

  /**
   * Add a single tag to this post.
   * @param int $tag_id
   */
  private function add_tag($tag_id) {
    // First let's escape the tag id for security purposes.
    $tag_id = Db::escape($tag_id);

    $q = <<<SQL
INSERT INTO `posts_tags`(`post_id`, `tag_id`) VALUES ('{$this->id}', '$tag_id')
SQL;

    Db::query($q);
  }

  /**
   * Remove all the tags from this post.
   */
  private function remove_all_tags() {
    // Let's build a safe query ($this->id is safe).
    $q = "DELETE FROM `posts_tags` WHERE `post_id` = '{$this->id}'";
    Db::query($q);
  }

  /**
   * Fetch the author of this post.
   * @return User
   */
  private function associated_author() {
    return User::find($this->author_id);
  }

  /**
   * Fetch the tags associated with this post.
   * @return array
   */
  private function associated_tags() {
    $q = <<<SQL
SELECT `tags`.* FROM `tags`
INNER JOIN `posts_tags`
ON `posts_tags`.`tag_id` = `tags`.`id`
WHERE `posts_tags`.`post_id` = '{$this->id}'
SQL;

    return Tag::new_instances_from_query($q);
  }
}
?>
