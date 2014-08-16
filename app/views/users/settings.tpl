{extends 'skeleton.tpl'}

{block name=container}

<h1>Profile settings</h1>
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
