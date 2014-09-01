{extends 'frontend.tpl'}

{block name=content}

<section class="all-games">

  <article class="with-most-ads">
    <h1>Game with most ads</h1>
    <h2>{$game_with_most_ads->name}</h2>
    <div class="number">
      <span>{$game_with_most_ads->ads_count}<span>
      ads
    </div>
  </article>

  {foreach from=$games item=game}
    <article>
      <h1>{$game->name}</h1>
      {image_path image=$game->cover_image}
      <section class="description">{$game->description}</section>
    </article>
  {/foreach}

</section>

{/block}
