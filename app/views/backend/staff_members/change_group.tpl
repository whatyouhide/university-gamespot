{extends 'backend.tpl'}

{block name=content}
<h1>Change {$member->first_name}'s group</h1>

<form
  action="{url to='/backend/staff_members/change_group' id=$member->id}"
  method="POST"
  >

  <p>Change from <b>{$member->group->name}</b> to:</p>
  {html_options name='group_id' options=$groups_for_select}

  <input type="submit" value="Change">

</form>

{include file='backend/staff_members/_permissions_table.tpl'}
{/block}
