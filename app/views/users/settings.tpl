{extends 'frontend.tpl'}

{block name=content}

<h1>Profile settings</h1>

<!-- Profile picture -->
{image_path image=$current_user->profile_picture default="profile_picture.jpg"}

{if $current_user->profile_picture}
  <a href="{$site_root}/users/delete_profile_picture">Remove</a>
{/if}

<form
  data-dropzone="single"
  enctype="multipart/form-data"
  action="{$site_root}/users/upload_profile_picture"
  method="POST">

  <input type="hidden" name="MAX_FILE_SIZE" value="300000000">
  <input type="file" name="profile_picture">
  <input type="submit" value="Add a profile picture">
</form>

<form action="{$site_root}/users/save_settings" type="POST">
  <input name="first_name" type="text" value="{$current_user->first_name}">
  <input name="last_name" type="text" value="{$current_user->last_name}">
  <input name="email" type="email" value="{$current_user->email}">
  <input type="submit" value="Save settings">
</form>

<form action="{$site_root}/users/change_password" type="POST">
  <input name="old_password" type="password" placeholder="Old password">
  <input name="new_password" type="password" placeholder="New password">
  <input type="submit" value="Change password">
</form>

{/block}
