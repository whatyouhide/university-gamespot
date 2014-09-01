{extends 'frontend.tpl'}

{block name=content}
  <h1 class="welcome">Profile</h1>

  <section class="create-ads">
    <a class="new-ad" href="{$site_root}/ads/nuevo?type=accessory">Create accessory ad</a>
    <a class="new-ad" href="{$site_root}/ads/nuevo?type=game">Create game ad</a>
  </section>

  <h2 class="my-ads">My ads</h2>
  {include file='users/_list_of_ads.tpl' game_or_accessory="game" list=$game_ads}
  {include file='users/_list_of_ads.tpl' game_or_accessory="accessory" list=$accessory_ads}
{/block}
