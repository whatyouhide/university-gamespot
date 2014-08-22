{extends 'backend.tpl'}

{block name=content}

<table class="game_categories">
  <tbody>
    {foreach from=$game_categories item=game_category}
      <tr data-id="{$game_category->id}">
        <td>
          <input
            type="text"
            placeholder="Name"
            value="{$game_category->name}"
          >
        </td>

        <td>
          <button data-save>Save</button>
          <button data-confirm data-destroy>Destroy</button>
        </td>
      </tr>
    {/foreach}

    <tr>
      <td><input type="text" placeholder="Name"></td>
      <td>
        <button data-add>Add</button>
      </td>
    </tr>
  </tbody>
</table>

{/block}
