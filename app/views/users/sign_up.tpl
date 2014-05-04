{extends 'skeleton.tpl'}

{block name=container}

<div>

  <h1 id="form-title">Sign up</h1>

  <div id="form-container">
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
        <input name="password" type="password" placeholder="At least 6 characters long">
      </div>

      <div class="field-set">
        <input type="submit">
      </div>
    </form>
  </div>

</div>

{/block}
