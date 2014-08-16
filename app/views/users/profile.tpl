{extends 'frontend.tpl'}

{block name=content}
  <h1 class="welcome">Welcome {$current_user->first_name}</h1>

  <a href="{$site_root}/users/settings">Settings</a>

  <section class="create-ads">
    <a href="{$site_root}/ads/nuevo?type=accessory">Create accessory ad</a>
    <a href="{$site_root}/ads/nuevo?type=game">Create game ad</a>
  </section>
{/block}
