<div class="flashes">
  {foreach from=$flash key=type item=msg}

    <div data-alert class="{$type} alert-box success">
      {$msg}
      <a href="#" class="close">&times;</a>
    </div>

  {/foreach}
</div>
