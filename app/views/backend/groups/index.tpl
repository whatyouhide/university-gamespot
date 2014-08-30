{extends 'backend.tpl'}

{block name=content}

<table class="groups">
  <thead>
    <th>Name</th>
    <th>Is admin</th>
    <th>Can blog</th>
    <th>Can manage products</th>
    <th>Can manage ads</th>
    <th>Can manage support</th>
    <th>Can block users</th>
    <th>Actions</th>
  </thead>

  <tbody>
    {foreach from=$groups item=group}
      {include file='backend/groups/_group_row.tpl'}
    {/foreach}
  </tbody>
</table>

<section class="add">
  <input type="text" name="name" placeholder="New group">
  <button data-add disabled>Add</button>
</section>

<div class="warnings">
  <p>
    Be careful when adding groups as groups cannot be deleted. If you want to
    virtually delete a group, just remove all its permissions and change the
    group of all its members.
  </p>
</div>

{/block}
