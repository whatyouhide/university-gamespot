{extends 'frontend.tpl'}

{block name=content}

<form action="{$site_root}/ads/update?id={$ad->id}" method="POST">
  <div class="field">
    <label for="city">City</label>
    <input name="city" type="text">
    <label for="price">Price ($)</label>
    <input name="price" type="number" step="0.01" min="0.0">
  </div>

  <div class="field">
    <label for="description">Description</label>
    <textarea name="description" id="texteditor" cols="30" rows="10"></textarea>
  </div>

  {html_options name=console_id options=$console_names}

  {if $ad->type eq "game"}
    {html_options name=game_id options=$game_names}
  {elseif $ad->type eq "accessory"}
    {html_options name=accessory_id options=$accessory_names}
  {/if}

  <div class="field">
    <input type="submit" value="Save">
    <button data-hijack>Pubblica</button>
  </div>
</form>

{/block}
