<?php
/**
 * This file contains the definition of the TagsController class.
 */

namespace Controllers;

use Models\Tag;

/**
 * A controller for managing tags.
 */
class BackendTagsController extends BackendController {
  /**
   * POST /tags/create
   * Create a new tag.
   */
  public function create() {
    $tag = Tag::create(['name' => $this->params['name']]);
    if ($tag->is_valid()) {
      $this->render_plain($tag->id);
    } else {
      $this->set_status_code(500);
    }
  }
}
?>
