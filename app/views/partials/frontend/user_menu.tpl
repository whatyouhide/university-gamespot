<ul class="user-menu">
  {if $current_user->is_regular()}
    {$profile_url="{url to='/users/profile'}"}
  {else}
    {$profile_url="{url to='/backend'}"}
  {/if}

  <li class="profile">
    <a href="{$profile_url}">
      {image_path image=$current_user->profile_picture default="profile_picture.jpg"}
      <span class="name">{$current_user->first_name}</span>
    </a>
  </li>

  <li class="settings">
    <a href="{url to='/users/settings'}">
      {image_path src="settings.png"}
    </a>
  </li>

  <li class="sign-out">
    <a href="{url to='/users/sign_out'}">
      {image_path src="sign-out.png"}
    </a>
  </li>
</ul>
