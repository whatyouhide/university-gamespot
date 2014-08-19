{extends 'frontend.tpl'}

{block name=content}
  <h1 class="welcome">Profile</h1>

  <a href="{$site_root}/users/settings">Settings</a>

  <section class="create-ads">
    <a href="{$site_root}/ads/nuevo?type=accessory">Create accessory ad</a>
    <a href="{$site_root}/ads/nuevo?type=game">Create game ad</a>
  </section>

  <section class="my-game-ads">
    {foreach from=$game_ads item=ad}
      <h1>Game ad: {$ad->game->name} ({$ad->console->name})</h1>
      <a data-confirm href="{$site_root}/ads/destroy?id={$ad->id}">Rimuovi</a>
      <a href="{$site_root}/ads/edit?id={$ad->id}">Modifica</a>
    {/foreach}
  </section>

  <section class="my-accessory-ads">
    {foreach from=$accessory_ads item=ad}
      <h1>Accessory ad: {$ad->accessory->name} ({$ad->console->name})</h1>
      <a data-confirm href="{$site_root}/ads/destroy?id={$ad->id}">Rimuovi</a>
      <a href="{$site_root}/ads/edit?id={$ad->id}">Modifica</a>
    {/foreach}
  </section>
{/block}
