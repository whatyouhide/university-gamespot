<header id="site-header">
  <div class="header-content">
    <h1>
      <a href="{$site_root}">{image_path src='logo.png' hoverable=true}</a>
    </h1>

    {include file='partials/frontend/menu.tpl'}

    <section class="user-links">
      {if isset($current_user) && $current_user}
        {include file='partials/frontend/user_menu.tpl'}
      {else}
        <ul>
          <li class="sign-in">
            <a href="{$site_root}/users/sign_in">Sign in</a>
          </li>
          <li class="sign-in">
            <a href="{$site_root}/users/sign_up">Sign up</a>
          </li>
        </ul>
      {/if}
    </section>
  </div>
</header>
