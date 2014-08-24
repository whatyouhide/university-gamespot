{extends 'mail_skeleton.tpl'}

{block name=content}
  {assign
    url
    "{url
      absolute=true
      to='/users/confirm'
      id=$user->id
      token=$user->confirmation_token
    }"
  }

  Hello {$user->first_name}.
  <br><br>
  To confirm your email address, click <a href="{$url}">here</a>.
{/block}
