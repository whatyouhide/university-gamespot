<?php
/**
 * This file contains the definition of the SupportTicket class.
 */

namespace Models;

/**
 * A support ticket.
 */
class SupportTicket extends Model {
  /**
   * {@inheritdoc}
   */
  public static $table_name = 'support_tickets';

  /**
   * @var array Possible topics of support tickets.
   */
  private static $topics = [
    'help',
    'bug report',
    'complain'
  ];

  /**
   * {@inheritdoc}
   * Also fetch the author of this ticket.
   */
  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->author = $this->associated_author();
  }

  /**
   * Return true if the ticket is closed, false otherwise.
   * @return bool
   */
  public function is_closed() {
    return $this->closed == '1';
  }

  /**
   * Toggle the 'closed' attribute of this ticket.
   */
  public function toggle_closed() {
    $this->update(['closed' => !$this->is_closed()]);
  }

  /**
   * Return a list of possible topics for a support ticket.
   * @return array
   */
  public static function topics() {
    return self::$topics;
  }

  /**
   * {@inheritdoc}
   */
  protected static function validate($attributes) {
    $validator = new Validator($attributes);
    $validator->must_not_be_empty('title');
    $validator->must_not_be_empty('author_id');
    $validator->must_be_included_in('topic', self::$topics);
    return $validator->error_messages();
  }

  /**
   * Fetch the auhtor of this ticket.
   * @return User
   */
  private function associated_author() {
    return User::find($this->author_id);
  }
}
?>
