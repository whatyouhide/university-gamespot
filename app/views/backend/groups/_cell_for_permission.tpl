<td class="permission">
  {if $group->$prop}
    {$checked='checked'}
  {else}
    {$checked=''}
  {/if}
  <input type="checkbox" name="{$prop}" value="1" {$checked}>
</td>
