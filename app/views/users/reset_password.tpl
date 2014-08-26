{extends 'skeleton.tpl'}
{block name=container}

{include file='partials/flashes.tpl'}

<div class="form-container">
  <h4><a href="{url to='/'}">Gamespot</a></h4>

  <h1>Reset your password</h1>

  <form
    action="{url to='/users/reset_password' token=$user->reset_token id=$user->id}"
    method="POST">
    <div>
      <input
        name="new_password"
        type="password"
        placeholder="Your new password">
    </div>

    <div>
      <input type="submit" value="Reset">
    </div>
  </form>
</div>

{/block}
