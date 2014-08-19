<ul class="my-{$game_or_accessory}-ads">
  {foreach from=$list item=ad}
    <li>
      <h1>
        {$game_or_accessory|@ucfirst} ad:
        {$ad->$game_or_accessory->name}
        ({$ad->console->name})
      </h1>

      {if $ad->is_draft()}
        <h2>Draft</h2>
      {else}
        <h2>Published</h2>
      {/if}

      <a data-confirm href="{$site_root}/ads/destroy?id={$ad->id}">Destroy</a>
      <a href="{$site_root}/ads/edit?id={$ad->id}">Edit</a>
    </li>
  {/foreach}
</ul>
