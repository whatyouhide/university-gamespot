{extends 'frontend.tpl'}

{block name=content}

<div class="ads-listing">
  {foreach from=$game_ads item=ad}
    <article>
      <h1>
        Game ad:
        <a href="{$site_root}/ads/show?id={$ad->id}">{$ad->game->name}</a>
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
        <a href="{$site_root}/ads/show?id={$ad->id}">{$ad->accessory->name}</a>
      </h1>

      {include file='ads/_main_image_or_entity_image.tpl' entity_image=$ad->accessory->image}

      <h2 class="city">in {$ad->city}</h2>
      <h2 class="price">{$ad->price}$</h2>
    </article>
  {/foreach}
</div>

{/block}
