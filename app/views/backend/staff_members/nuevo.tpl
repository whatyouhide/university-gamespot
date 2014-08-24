{extends 'backend.tpl'}

{block name=content}
<h1>New staff member</h1>

<form action="{url to='/backend/staff_members/create'}" method="POST">
  <label for="first_name">First name</label>
  <input name="first_name" type="text" placeholder="John">

  <label for="last_name">Last name</label>
  <input name="last_name" type="text" placeholder="Doe">

  <label for="email">Email</label>
  <input name="email" type="email" placeholder="john@doe.com">

  <label for="group_id">Group</label>
  {html_options name='group_id' options=$groups_for_select}

  <input type="submit" value="Create staff member">
</form>

{include file='backend/staff_members/_permissions_table.tpl'}
{/block}
