{extends 'backend.tpl'}
{block name=content}

<section class="wrapper">
  <h1>Support tickets</h1>

  <div class="filter">
    <a href="#" data-filter data-show-closed>show closed</a>
    /
    <a href="#" data-filter data-hide-closed>hide closed</a>
  </div>

  {foreach from=$support_tickets item=ticket}
    <article data-status="{if $ticket->is_closed()}closed{else}open{/if}">
      <h1>
        <a href="{url to='/backend/support_tickets/show' id=$ticket->id}">
          <span class="ticket-number">#{$ticket->id}</span> {$ticket->title}
        </a>
      </h1>

      {include 'backend/support_tickets/_status.tpl'}
      {include 'backend/support_tickets/_close_or_reopen.tpl'}
    </article>
  {/foreach}
</section>

{/block}
