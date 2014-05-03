{extends 'skeleton.tpl'}

{block name=container}

<div class="signin">

  <h1 id="form-title">Sign in</h1>

  <div id="form-container">

    {if $sign_in_error}
      <div class="sign-in-error error">Wrong email or password.</div>
    {/if}

    <form action="{$site_root}/sign_in/post" method="POST">
      <div class="field-set">
        <label for="email">Email</label>
        <input name="email" type="email" placeholder="john.doe@example.com">
      </div>

      <div class="field-set">
        <label for="password">Password</label>
        <input name="password" type="password" placeholder="At least 6 characters long">
      </div>

      <div class="field-set">
        <input type="submit">
      </div>
    </form>
    </div>

</div>

{/block}
