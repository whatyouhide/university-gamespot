<ul class="my-{$game_or_accessory}-ads">
  {foreach from=$list item=ad}
    <li>
      <h3>
        <span class="type">{$game_or_accessory|@ucfirst} ad</span>
        {$ad->$game_or_accessory->name}
        ({$ad->console->name})
        <span class="status">{if $ad->is_draft()}Draft{else}Published{/if}</span>
      </h3>

      <div class="actions">
        <a href="{$site_root}/ads/edit?id={$ad->id}">Edit</a>
        /
        <a class="destroy" data-confirm href="{$site_root}/ads/destroy?id={$ad->id}">Remove</a>
      </div>
    </li>
  {/foreach}
</ul>
