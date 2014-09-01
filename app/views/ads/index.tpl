{extends 'frontend.tpl'}

{block name=content}

{include 'ads/_filter_form.tpl'}

<div class="ads-listing">
  {if empty($game_ads) && empty($accessory_ads)}
    <div class="no-results">No results.</div>
  {/if}

  {foreach from=$game_ads item=ad}
    <a href="{url to='/ads/show' id=$ad->id}">
      <article>
        <header>
          <h4 class="type">Game ad</h4>
          <h2>{$ad->game->name}</h2>
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
      </article>
    </a>
  {/foreach}

  {foreach from=$accessory_ads item=ad}
    <a href="{url to='/ads/show' id=$ad->id}">
      <article>
        <header>
          <h4 class="type">Accessory ad</h4>
          <h2>{$ad->accessory->name}</h2>
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
      </article>
    </a>
  {/foreach}
</div>

{/block}
