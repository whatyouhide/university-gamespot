{extends 'mail_skeleton.tpl'}

{block name=content}
  Hello {$staff_member->first_name}.
  <br>
  <br>

  A Gamespot admin made you ({$staff_member->email}) a staff member.
  <br>
  You belong to the <b>{$staff_member->group->name}</b> group.

  <br>
  <br>

  Your password (keep it secret!) is:
  <br>
  <br>
  {$password}

  <br>
  <br>

  To sign in, you can visit the
  <a href="{url to='/users/sign_in' absolute=true}">log in page</a>.
{/block}
