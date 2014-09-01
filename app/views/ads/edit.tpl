{extends 'frontend.tpl'}

{block name=content}

<section class="edit-ad">
  <h1>Edit ad</h1>
  {if $ad->published eq "0"}
    <h2>Draft</h2>
  {else}
    <h2>Published</h2>
  {/if}

  <form
    class="dropzone"
    action="{$site_root}/ads/upload_image?id={$ad->id}"
    method="POST"
  >
    <div class="fallback"><input name="file" type="file"></div>
  </form>

  {include file='ads/_list_of_images.tpl' images=$ad->images}

  <form action="{$site_root}/ads/update?id={$ad->id}" method="POST">
    <input type="hidden" name="published" value="{$ad->published}">

    <div class="selects">
      {html_options name=console_id options=$console_names selected=$ad->console->id}

      {if $ad->type eq "game"}
        {html_options name=game_id options=$game_names selected=$ad->game->id}
      {elseif $ad->type eq "accessory"}
        {html_options name=accessory_id options=$accessory_names selected=$ad->accessory->id}
      {/if}
    </div>

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

    <div class="field actions">
      {if $ad->published eq "0"}
        <input type="submit" value="Save">
        <button data-hijack data-confirm="Are you sure?">Publish</button>
      {else}
        <input type="submit" value="Update">
      {/if}
    </div>

    {if $ad->is_draft()}
      <p class="warning">Be careful: when an ad is published, it can't be turned back into a draft.</p>
    {/if}
  </form>
</section>

{/block}
