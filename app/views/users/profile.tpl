{extends 'frontend.tpl'}

{block name=content}
  <h1 class="welcome">Profile</h1>

  <a href="{$site_root}/users/settings">Settings</a>

  <section class="create-ads">
    <a href="{$site_root}/ads/nuevo?type=accessory">Create accessory ad</a>
    <a href="{$site_root}/ads/nuevo?type=game">Create game ad</a>
  </section>

  <section class="my-game-ads">
  </section>
  <section class="my-accessory-ads">
  </section>
{/block}
