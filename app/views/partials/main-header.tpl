<header id="site-header">
  <h1>Gamespot</h1>
  <section class="user-links">
    {if $smarty.session.user}
      <a href="{$site_root}/users/sign_out">Sign out</a>
      <a href="{$site_root}/users/profile">Profile</a>
    {else}
      <a href="{$site_root}/users/sign_in">Sign in</a>
      or
      <a href="{$site_root}/users/sign_up">sign up</a>
    {/if}
  </section>
</header>
