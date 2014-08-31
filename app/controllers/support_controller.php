<?php
/**
 * This file contains the definition of the SupportController class.
 */

namespace Controllers;

use Models\SupportTicket;

/**
 * A controller for opening support tickets in the frontend.
 */
class SupportController extends Controller {
  /**
   * {@inheritdoc}
   */
  protected static $before_filters = array(
    'ensure_regular_user' => 'all'
  );

  /**
   * GET /support
   * Display the form to open a new ticket.
   */
  public function index() {
    $this->topics = array_combine(
      SupportTicket::topics(),
      SupportTicket::topics()
    );
  }

  /**
   * POST /support/create_ticket
   * Create the new ticket.
   */
  public function create_ticket() {
    $new_ticket = SupportTicket::create($this->ticket_attributes());

    if ($new_ticket->is_valid()) {
      redirect('/support', ['notice' => 'Ticket created successfully']);
    } else {
      redirect('/support', ['error' => $new_ticket->errors_as_string()]);
    }
  }

  /**
   * <b>Filter</b>
   * Ensure the currently logged in user isn't a staff member.
   */
  protected function ensure_regular_user() {
    if (!$this->current_user->is_regular()) {
      redirect('/', ['info' => 'This feature is enabled for regular users only']);
    }
  }

  /**
   * Return valid attributes for a SupportTicket instance.
   * @return array
   */
  private function ticket_attributes() {
    return [
      'title' => $this->params['title'],
      'content' => $this->params['content'],
      'topic' => $this->params['topic'],
      'author_id' => $this->current_user->id
    ];
  }
}
?>
