{extends 'frontend.tpl'}

{block name=content}

<div class="ads-listing">
  {foreach from=$ads item=ad}
    <article>
      <h1>
        <a href="{$site_root}/ads/show?id={$ad->id}">{$ad->game->name}</a>
      </h1>
      {image_path image=$ad->game->cover_image}
      <h2 class="city">in {$ad->city}</h2>
      <h2 class="price">{$ad->price}$</h2>
    </article>
  {/foreach}
</div>

{/block}
