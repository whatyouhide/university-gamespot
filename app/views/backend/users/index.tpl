{extends 'backend.tpl'}

{block name=content}

<section class="wrapper">
  <h1>Users</h1>

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
</section>

{/block}
