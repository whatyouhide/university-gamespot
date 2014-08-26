{extends 'skeleton.tpl'}
{block name=container}

{include file='partials/flashes.tpl'}

<div class="form-container">
  <h4><a href="{url to='/'}">Gamespot</a></h4>
  <h1>Password recovery</h1>

  <div class="what-will-happen">
    <p>
      Instructions to reset your password will be sent to your email address.
    </p>
  </div>

  <form action="{url to='/users/forgot_password'}" method="POST">
    <div>
      <input
        name="recovery_email"
        type="email"
        placeholder="Your email address">
    </div>

    <div>
      <input type="submit" value="Send me instructions">
    </div>
  </form>
</div>

{/block}
