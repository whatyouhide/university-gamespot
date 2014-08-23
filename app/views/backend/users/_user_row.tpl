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

  <td>{$user->created_at}</td>

  <td class="actions">
    {if $user->is_blocked()}
      <a
        data-confirm
        class="unblock"
        href="{url to='/backend/users/unblock' id=$user->id}">Unblock</a>
    {else}
      <a
        data-confirm
        class="block"
        href="{url to='/backend/users/block' id=$user->id}">Block</a>
    {/if}
  </td>
</tr>
