<header id="site-header">
  <h1><a href="{$site_root}">Gamespot</a></h1>
  <section class="user-links">
    {if isset($current_user) && $current_user}
      <a href="{$site_root}/users/sign_out">Sign out</a>
      <a href="{$site_root}/users/profile">Profile</a>
    {else}
      <a href="{$site_root}/users/sign_in">Sign in</a>
      or
      <a href="{$site_root}/users/sign_up">sign up</a>
    {/if}
  </section>
</header>
