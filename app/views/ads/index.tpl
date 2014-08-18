{extends 'frontend.tpl'}

{block name=content}

<div class="ads-listing">
  {foreach from=$game_ads item=game_ad}
    <article>
      <h1>
        Game ad:
        <a href="{$site_root}/ads/show?id={$game_ad->id}">{$game_ad->game->name}</a>
      </h1>
      {image_path image=$game_ad->game->cover_image}
      <h2 class="city">in {$game_ad->city}</h2>
      <h2 class="price">{$game_ad->price}$</h2>
    </article>
  {/foreach}

  {foreach from=$accessory_ads item=accessory_ad}
    <article>
      <h1>
        Accessory ad:
        <a href="{$site_root}/ads/show?id={$accessory_ad->id}">{$accessory_ad->accessory->name}</a>
      </h1>
      {image_path image=$accessory_ad->accessory->image}
      <h2 class="city">in {$accessory_ad->city}</h2>
      <h2 class="price">{$accessory_ad->price}$</h2>
    </article>
  {/foreach}
</div>

{/block}
