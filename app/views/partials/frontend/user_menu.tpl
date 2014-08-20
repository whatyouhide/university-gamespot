<ul class="user-menu">
  <li class="profile">
    <a href="{url to='/users/profile'}">
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
