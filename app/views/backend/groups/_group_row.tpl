<tr class="group" data-id="{$group->id}">
  {assign checked_attr 'checked="checked"'}

  <td class="name"><span>{$group->name}</span></td>

  {include 'backend/groups/_cell_for_permission.tpl' prop=is_admin}
  {include 'backend/groups/_cell_for_permission.tpl' prop=can_blog}
  {include 'backend/groups/_cell_for_permission.tpl' prop=can_manage_products}
  {include 'backend/groups/_cell_for_permission.tpl' prop=can_manage_ads}
  {include 'backend/groups/_cell_for_permission.tpl' prop=can_manage_support}
  {include 'backend/groups/_cell_for_permission.tpl' prop=can_block_users}

  <td class="actions">
    <button data-save>Save</button>
  </td>
</tr>
