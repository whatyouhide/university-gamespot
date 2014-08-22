{extends 'skeleton.tpl'}

{block name=container}

{include file='partials/flashes.tpl'}

<div class="form-container">
  <h4><a href="{url to='/'}">Gamespot</a></h4>
  <h1>Sign in</h1>

  <form action="{$site_root}/users/sign_in" method="POST">
    <div class="field-set">
      <input name="email" type="email" placeholder="Email">
    </div>

    <div class="field-set">
      <input name="password" type="password" placeholder="Password">
    </div>

    <div class="field-set">
      <input type="submit" value="Sign in">
    </div>
  </form>
</div>

{/block}
