{extends 'backend.tpl'}

{block name=content}

<table class="users">
  <thead>
    <th>Name</th>
    <th>Email</th>
    <th>Created at</th>
    <th>Actions</th>
  </thead>

  <tbody>
    {foreach from=$users item=user}
      {include file='backend/users/_user_row.tpl'}
    {/foreach}
  </tbody>
</table>

{/block}
