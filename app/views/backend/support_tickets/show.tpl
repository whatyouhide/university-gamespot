{extends 'backend.tpl'}
{block name=content}

  <section data-status="{if $ticket->is_closed()}closed{else}open{/if}">
   <header>
      <h1>
        {$ticket->title}
        <span class="ticket-number">#{$ticket->id}</span>
      </h1>
      {include 'backend/support_tickets/_status.tpl'}
    </header>

    <section class="content">{$ticket->content|nl2br}</section>

    <div class="actions">
      {mailto
        address=$ticket->author->email
        text='Respond to the ticket'
        subject="Support - ticket #{$ticket->id}"
      }
      /
      {include 'backend/support_tickets/_close_or_reopen.tpl'}
    </div>
</section>
{/block}
