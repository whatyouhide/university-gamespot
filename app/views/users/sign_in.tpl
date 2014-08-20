{extends 'skeleton.tpl'}

{block name=container}

<div class="form-container">
  <h1>Sign in</h1>

  {if $sign_in_error}
    <div class="sign-in-error">Wrong email or password.</div>
  {/if}

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
