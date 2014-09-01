<a class="toggle-status" data-confirm href="{url to='/backend/support_tickets/toggle_closed' id=$ticket->id}">
  {if $ticket->is_closed()}Reopen{else}Close{/if}
</a>
