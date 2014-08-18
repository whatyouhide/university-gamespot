{extends 'frontend.tpl'}

{block name=content}

<h1>Ad</h1>
{if $ad->published eq "0"}
  <h2>Draft</h2>
{/if}

<form action="{$site_root}/ads/update?id={$ad->id}" method="POST">
  <input type="hidden" name="published" value="{$ad->published}">

  <div class="field">
    <label for="city">City</label>
    <input name="city" type="text" value="{$ad->city}">
    <label for="price">Price ($)</label>
    <input name="price" type="number" step="0.01" min="0.0" value="{$ad->price}">
  </div>

  <div class="field">
    <label for="description">Description</label>
    <textarea
      name="description"
      id="texteditor"
      cols="30"
      rows="10">{$ad->description}</textarea>
  </div>

  {html_options name=console_id options=$console_names selected=$ad->console->id}

  {if $ad->type eq "game"}
    {html_options name=game_id options=$game_names selected=$ad->game->id}
  {elseif $ad->type eq "accessory"}
    {html_options name=accessory_id options=$accessory_names selected=$ad->accessory->id}
  {/if}

  <div class="field">
    <input type="submit" value="Save">
    <button data-hijack>Pubblica</button>
  </div>
</form>

{/block}
