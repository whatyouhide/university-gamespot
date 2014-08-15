{extends 'frontend.tpl'}

{block name=content}
<form action="{$site_root}/ads/create" method="POST">
  <div class="field">
    <label for="city">City</label>
    <input name="city" type="text">
  </div>

  <div class="field">
    <label for="description">Description</label>
    <textarea name="description" id="texteditor" cols="30" rows="10"></textarea>
  </div>

  <div class="field">
    <label for="price">Price (&#8364;)</label>
    <input name="price" type="number" step="0.01" min="0.0">
  </div>

  {html_options name=console_name options=$console_names}

  {* Display options based on what type of ad this is *}
  {if $ad_type eq "game"}
    {html_options name=game_name options=$game_names}
    <input type="hidden" name="ad_type" value="game">
  {elseif $ad_type eq "accessory"}
    {html_options name=accessory_name options=$accessory_names}
    <input type="hidden" name="ad_type" value="accessory">
  {/if}

  <div class="field">
    <input type="submit">
  </div>
</form>
{/block}
