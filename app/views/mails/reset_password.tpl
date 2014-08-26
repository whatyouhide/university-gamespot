{extends 'mail_skeleton.tpl'}

{block name=content}

{assign
  url
  "{url
    to='/users/reset_password'
    token=$user->reset_token
    id=$user->id
    absolute=true
  }"
}

Hello {$user->first_name}.
<br>
<br>

You requested to reset your password.
<br>
<br>

Just click
<a href="{$url}">here</a>.

{/block}
