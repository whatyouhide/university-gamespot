{extends 'frontend.tpl'}

{block name=content}

<h1 class="main-title">Ads</h1>

{include 'ads/_filter_form.tpl'}

<div class="ads-listing">
  {if empty($game_ads) && empty($accessory_ads)}
    <div class="no-results">No results.</div>
  {/if}

  {foreach from=$game_ads item=ad}
    <article>
      <a class="see-ad" href="{url to='/ads/show' id=$ad->id}">See ad →</a>
      <header>
        <h4 class="type">Game ad</h4>
        <h2><a class="article" href="{url to='/ads/show' id=$ad->id}">{$ad->game->name}</a></h2>
      </header>

      <div class="infos">
        <div class="image">
          {include file='ads/_main_image_or_entity_image.tpl' entity_image=$ad->game->cover_image}
        </div>
        <div class="city-and-price">
          <h5 class="city">{$ad->city}</h5>
          <h3 class="price">${$ad->price}</h3>
        </div>
      </div>

      <section class="description">{$ad->description|truncate:450}</section>
    </article>
  {/foreach}

  {foreach from=$accessory_ads item=ad}
    <article>
      <a class="see-ad" href="{url to='/ads/show' id=$ad->id}">See ad →</a>
      <header>
        <h4 class="type">Accessory ad</h4>
        <h2><a class="article" href="{url to='/ads/show' id=$ad->id}">{$ad->accessory->name}</a></h2>
      </header>

      <div class="infos">
        <div class="image">
          {include file='ads/_main_image_or_entity_image.tpl' entity_image=$ad->accessory->image}
        </div>

        <div class="city-and-price">
          <h5 class="city">{$ad->city}</h5>
          <h3 class="price">{$ad->price}$</h3>
        </div>
      </div>

      <section class="description">{$ad->description|truncate:450}</section>
    </article>
  {/foreach}
</div>

{/block}
