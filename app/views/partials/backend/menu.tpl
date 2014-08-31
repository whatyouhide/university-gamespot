<nav id="menu">
  <h1>
    <a href="{url to='/backend'}">{image_path src='logo.png' hoverable=true}</a>
  </h1>

  <ul class="sections">
    <li class="{if !$current_user->can('manage_products')}inactive{/if}">
      <a href="{url to='/backend/consoles'}">Consoles</a>
    </li>

    <li class="{if !$current_user->can('manage_products')}inactive{/if}">
      <a href="{url to='/backend/games'}">Games</a>
    </li>

    <li class="{if !$current_user->can('manage_products')}inactive{/if}">
      <a href="{url to='/backend/game_categories'}">Game categories</a>
    </li>

    <li class="{if !$current_user->can('manage_products')}inactive{/if}">
      <a href="{url to='/backend/accessories'}">Accessories</a>
    </li>

    <li class="{if !$current_user->can('manage_ads')}inactive{/if}">
      <a href="{url to='/backend/ads'}">Ads</a>
    </li>

    <li class="{if !$current_user->can('block_users')}inactive{/if}">
      <a href="{url to='/backend/users'}">Users</a>
    </li>

    <li class="{if !$current_user->is_admin()}inactive{/if}">
      <a href="{url to='/backend/staff_members'}">Staff members</a>
    </li>

    <li class="{if !$current_user->is_admin()}inactive{/if}">
      <a href="{url to='/backend/groups'}">Groups</a>
    </li>

    <li class="{if !$current_user->can('blog')}inactive{/if}">
      <a href="{url to='/backend/posts'}">Blog</a>
    </li>

    <li class="{if !$current_user->can('manage_support')}inactive{/if}">
      <a href="{url to='/backend/support_tickets'}">Support</a>
    </li>

    <li class="{if !$current_user->is_admin()}inactive{/if}">
      <a href="{url to='/backend/errors'}">Errors</a>
    </li>
  </ul>

  <ul class="user-actions">
    <li><a href="{url to='/'}">Frontend</a></li>
    <li><a href="{url to="/users/sign_out"}">Sign out</a></li>
  <ul>
</nav>
