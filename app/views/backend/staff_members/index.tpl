{extends 'backend.tpl'}

{block name=content}

<section class="wrapper">
  <h1>Staff members</h1>

  <table class="staff_members">
    <thead>
      <th>Name</th>
      <th>Email</th>
      <th>Group</th>
      <th>Created at</th>
      <th>Actions</th>
    </thead>

    <tbody>
      {foreach from=$grouped_staff_members key=group_name item=group_members}
        <tr class="group-header">
          <td colspan="5">{$group_name}</td>
        </tr>

        {foreach from=$group_members item=user}
          {include file='backend/staff_members/_staff_member_row.tpl'}
        {/foreach}
      {/foreach}
    </tbody>
  </table>

  <a class="new-item" href="{url to='/backend/staff_members/nuevo'}">New staff member</a>

  {include file='backend/staff_members/_permissions_table.tpl'}
</section>

{/block}
