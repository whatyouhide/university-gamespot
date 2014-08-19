{extends 'frontend.tpl'}

{block name=content}

<div class="single-ad">
  {if $ad->type eq "game"}
    {assign 'url' "{$site_root}/games/show?id={$ad->game->id}"}
    {assign 'name' $ad->game->name}
    {assign 'entity_image' $ad->game->cover_image}
  {else}
    {assign 'url' "{$site_root}/accessories/show?id={$ad->game->id}"}
    {assign 'name' $ad->accessory->name}
    {assign 'entity_image' $ad->accessory->image}
  {/if}

  <header>
    <h1><a href="{$url}">{$name}</a></h1>
    {include file='ads/_main_image_or_entity_image.tpl' entity_image=$entity_image}
    <div class="price">{$ad->price}€</div>
    <div class="city">{$ad->city}</div>
  </header>

  <section class="description">{$ad->description}</section>

  <section class="images">
    {foreach from=$ad->remaining_images() item=image}
      {image_path image=$image}
    {/foreach}
  </section>

  {include file='ads/_contact_form.tpl'}
</div>

{/block}
