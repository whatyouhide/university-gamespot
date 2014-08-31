{extends 'frontend.tpl'}

{block name=content}

<form action="{url to='/ads/filter'}" method="POST">
  <label for="console">Filter by console:</label>
  {html_options name=console options=$consoles_for_select}

  <div class="type">
    <label for="type">Ad type:</label>

    <div>
      <label><input type="radio" name="type" value="game" checked> Game</label>
      {html_options name=game options=$games_for_select}
    </div>
    <div>
      <label><input type="radio" name="type" value="accessory"> Accessory</label>
      {html_options name=accessory options=$accessories_for_select}
    </div>
  </div>

  <label for="city">Filter by city:</label>
  {html_options name=city options=$cities_for_select}

  <label>
    <input type="checkbox" name="last-7-days" value="true">
    Last 7 days
  </label>

  <label for="max-price">
    Maximum price (0 means no price filter)
  </label>
  <div
    class="range-slider"
    data-slider="0"
    data-options="display_selector: #slider-output; start: 0; end: 40;"
    >
    <span class="range-slider-handle" role="slider" tabindex="0"></span>
    <span class="range-slider-active-segment"></span>
    <input name="max-price" type="hidden">
  </div>
  <div><span id="slider-output"></span></div>

</form>

<div class="ads-listing">
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
