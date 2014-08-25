{extends 'frontend.tpl'}

{block name=content}

<h1>Profile settings</h1>

<div class="row">
  <form action="{$site_root}/users/save_settings" type="POST" class="infos">
    <input name="first_name" type="text" value="{$current_user->first_name}">
    <input name="last_name" type="text" value="{$current_user->last_name}">
    <input name="email" type="email" value="{$current_user->email}">
    <input type="submit" value="Save settings">
  </form>

  <!-- Profile picture -->
  <section class="profile-picture">
    <div class="image-container">
      {image_path
        image=$current_user->profile_picture
        gravatar=$current_user->email
      }
    </div>

    <div class="change-and-remove">
      <form
        data-dropzone="single"
        enctype="multipart/form-data"
        action="{$site_root}/users/upload_profile_picture"
        method="POST">

        <input type="hidden" name="MAX_FILE_SIZE" value="300000000">
        <input type="file" name="profile_picture">
        <input type="submit" value="Add profile picture" disabled>
      </form>

      <!-- Remove button -->
      {if $current_user->profile_picture}
        <a
          class="remove-profile-picture"
          data-confirm
          href="{url to='/users/delete_profile_picture'}"
        >
          Remove
        </a>
      {/if}
    </div>

  </section>
</div>

<form action="{url to='/users/change_password'}" method="POST" class="password">
  <div class="field">
    <input name="old_password" type="password" placeholder="Old password">
  </div>
  <div class="field">
    <input name="new_password" type="password" placeholder="New password">
  </div>
  <div class="field">
    <input type="submit" value="Change password">
  </div>
</form>

{/block}
