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
   * Return a list of possible topics for a support ticket.
   * @return array
   */
  public static function topics() {
    return self::$topics;
  }

  /**
   * {@inheritdoc}
   */
  public static function validate($attributes) {
    $validator = new Validator($attributes);
    $validator->must_not_be_empty('title');
    $validator->must_not_be_empty('author_id');
    $validator->must_be_included_in('topic', self::$topics);
    return $validator->error_messages();
  }
}
?>
