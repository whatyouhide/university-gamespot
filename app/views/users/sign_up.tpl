{extends 'skeleton.tpl'}

{block name=container}

  {include file='partials/flashes.tpl'}

  <div class="form-container">
    <h4><a href="{url to='/'}">Gamespot</a></h4>
    <h1 id="form-title">Sign up</h1>

    <form action="{$site_root}/users/sign_up" method="POST">
      <div class="field-set">
        <div class="sub-field-set">
          <label for="first_name">First name</label>
          <input name="first_name" type="text" placeholder="John">
        </div>

        <div class="sub-field-set">
          <label for="last_name">Last name</label>
          <input name="last_name" type="text" placeholder="Doe">
        </div>
      </div>

      <div class="field-set">
        <label for="email">Email</label>
        <input name="email" type="email" placeholder="john.doe@example.com">
      </div>

      <div class="field-set">
        <label for="password">Password</label>
        <input name="password" type="password" placeholder="Your password">
        <input name="password_confirmation" type="password" placeholder="Retype your password">
      </div>

      <div class="field-set">
        <input type="submit">
      </div>
    </form>
  </div>
{/block}
