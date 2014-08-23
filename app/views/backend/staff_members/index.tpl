{extends 'backend.tpl'}

{block name=content}

<table class="staff_members">
  <thead>
    <th>Name</th>
    <th>Email</th>
    <th>Created at</th>
    <th>Actions</th>
  </thead>

  <tbody>
    {foreach from=$staff_members item=user}
      {include file='backend/staff_members/_staff_member_row.tpl'}
    {/foreach}
  </tbody>
</table>

{/block}
