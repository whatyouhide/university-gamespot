{extends 'backend.tpl'}

{block name=content}

<table class="accessories">
  <thead>
    <th>Name</th>
    <th>Release date</th>
    <th>Console</th>
    <th>Producer</th>
    <th>Description</th>
    <th>Actions</th>
  </thead>

  <tbody>
    {foreach from=$accessories item=accessory}
      {include file='backend/accessories/_accessory_row.tpl'}
    {/foreach}
  </tbody>
</table>

<a href="{url to='/backend/accessories/nuevo'}">New accessory</a>

{/block}
