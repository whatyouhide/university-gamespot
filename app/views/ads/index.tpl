{extends 'frontend.tpl'}

{block name=content}

{include 'ads/_filter_form.tpl'}

<div class="ads-listing">
  {if empty($game_ads) && empty($accessory_ads)}
    <div class="no-results">No results.</div>
  {/if}

  {foreach from=$game_ads item=ad}
    <article>
      <h1>
        Game ad: {$ad->game->name}
        <a href="{url to='/ads/show' id=$ad->id}">Show</a>
      </h1>

      {include file='ads/_main_image_or_entity_image.tpl' entity_image=$ad->game->cover_image}

      <h2 class="city">in {$ad->city}</h2>
      <h2 class="price">{$ad->price}$</h2>
    </article>
  {/foreach}

  {foreach from=$accessory_ads item=ad}
    <article>
      <h1>
        Accessory ad:
        <a href="{url to='/ads/show' id=$ad->id}">{$ad->accessory->name}</a>
      </h1>

      {include file='ads/_main_image_or_entity_image.tpl' entity_image=$ad->accessory->image}

      <h2 class="city">in {$ad->city}</h2>
      <h2 class="price">{$ad->price}$</h2>
    </article>
  {/foreach}
</div>

{/block}
