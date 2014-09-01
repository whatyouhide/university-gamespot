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
    <a href="{url to='/ads/by_game' id=$game_with_most_ads->id}">See ads</a>
  </article>

  {foreach from=$games item=game}
    <article>
      <h1>
        <a href="{url to='/ads/by_game' id=$game->id}">
          {$game->name}
        </a>
      </h1>
      {image_path image=$game->cover_image}
      <section class="description">{$game->description}</section>
    </article>
  {/foreach}

</section>

{/block}
