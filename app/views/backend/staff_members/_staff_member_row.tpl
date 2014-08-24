<tr>
  <td>
    <span class="name">{$user->full_name()}</span>
    {if $user->is_blocked()}
      <span class="blocked">Blocked</span>
    {/if}
  </td>

  <td>
    <a href="mailto:{$user->email}">{$user->email}</a>
  </td>

  <td>{$user->group->name}</td>

  <td>{$user->created_at}</td>

  <td class="actions">
    {if $user->is_blocked()}
      <a
        data-confirm
        class="unblock"
        href="{url to='/backend/staff_members/unblock' id=$user->id}">Unblock</a>
    {else}
      <a
        data-confirm
        class="block"
        href="{url to='/backend/staff_members/block' id=$user->id}">Block</a>
    {/if}

    <a href="{url to='/backend/staff_members/change_group' id=$user->id}">
      Change group
    </a>

    <a
      data-confirm
      href="{url to='/backend/staff_members/destroy' id=$user->id}">Destroy</a>
  </td>
</tr>
