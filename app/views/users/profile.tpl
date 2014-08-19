{extends 'frontend.tpl'}

{block name=content}
  <h1 class="welcome">Profile</h1>

  <a href="{$site_root}/users/settings">Settings</a>

  <section class="create-ads">
    <a href="{$site_root}/ads/nuevo?type=accessory">Create accessory ad</a>
    <a href="{$site_root}/ads/nuevo?type=game">Create game ad</a>
  </section>

  {include file='users/_list_of_ads.tpl' game_or_accessory="game" list=$game_ads}
  {include file='users/_list_of_ads.tpl' game_or_accessory="accessory" list=$accessory_ads}
{/block}
