<section class="permissions-table">
  <h1>Groups and permissions</h1>

  <table>
    <thead>
      <th>Group name</th>
      <th>Is admin</th>
      <th>Can blog</th>
      <th>Can moderate blog</th>
      <th>Can manage products</th>
      <th>Can manage ads</th>
      <th>Can manage support</th>
      <th>Can block users</th>
    </thead>

    <tbody>
      {foreach from=$groups item=group}
        <tr>
          <td>{$group->name}</td>
          <td>
            {if $group->is_admin}
              {assign can 'yes'}
            {else}
              {assign can 'no'}
            {/if}
            <span class="{$can}">{$can}</span>
          </td>

          <td>
            {if $group->can_blog}
              {assign can 'yes'}
            {else}
              {assign can 'no'}
            {/if}
            <span class="{$can}">{$can}</span>
          </td>

          <td>
            {if $group->can_moderate_blog}
              {assign can 'yes'}
            {else}
              {assign can 'no'}
            {/if}
            <span class="{$can}">{$can}</span>
          </td>

          <td>
            {if $group->can_manage_products}
              {assign can 'yes'}
            {else}
              {assign can 'no'}
            {/if}
            <span class="{$can}">{$can}</span>
          </td>

          <td>
            {if $group->can_manage_ads}
              {assign can 'yes'}
            {else}
              {assign can 'no'}
            {/if}
            <span class="{$can}">{$can}</span>
          </td>

          <td>
            {if $group->can_manage_support}
              {assign can 'yes'}
            {else}
              {assign can 'no'}
            {/if}
            <span class="{$can}">{$can}</span>
          </td>

          <td>
            {if $group->can_block_users}
              {assign can 'yes'}
            {else}
              {assign can 'no'}
            {/if}
            <span class="{$can}">{$can}</span>
          </td>
        </tr>
      {/foreach}
    <tbody>
  </table>
</section>
