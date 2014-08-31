<?php
/**
 * This file contains the definition of the BackendSupportTicketsController class.
 */

namespace Controllers;

use Models\SupportTicket;

/**
 * A controller to manage support tickets in the backend.
 */
class BackendSupportTicketsController extends BackendController {
  /**
   * {@inheritdoc}
   */
  protected static $before_filters = array(
    'restrict' => 'all',
    'set_ticket' => ['toggle_closed', 'show']
  );

  /**
   * GET /support_tickets
   * Show a list of support tickets.
   */
  public function index() {
    $this->support_tickets = SupportTicket::all();
  }

  /**
   * GET /support_tickets/toggle_closed?id=1
   * Toggle the 'closed' attribute of a given ticket.
   */
  public function toggle_closed() {
    $will_be_closed = !$this->ticket->is_closed();

    if ($will_be_closed) {
      $notice = 'Ticked closed successfully';
    } else {
      $notice = 'Ticked re-opened successfully';
    }

    $this->ticket->toggle_closed();
    redirect('/backend/support_tickets', ['notice' => $notice]);
  }

  /**
   * GET /support_tickets/show?id=1
   * Show a support ticket.
   */
  public function show() {
  }

  /**
   * <b>Filter</b>
   * Set the `ticket` instance variable.
   */
  protected function set_ticket() {
    $this->ticket = $this->safe_find_from_id('SupportTicket');
  }

  /**
   * <b>Filter</b>
   * Restrict access to the users with the right permission.
   */
  protected function restrict() {
    $this->restrict_to_permission('manage_support');
  }
}
?>
