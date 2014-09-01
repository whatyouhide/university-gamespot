{extends 'frontend.tpl'}

{block name=content}

<section class="all">

  <article class="with-most-ads">
    <a href="{url to='/ads/by_game' id=$game_with_most_ads->id}">
      <h1>★ Game with most ads ★</h1>
      <h2>{$game_with_most_ads->name}</h2>
      <div class="infos">
        <div class="number">
          <span>{$game_with_most_ads->ads_count}<span>
          ads
        </div>
      </div>
    </a>
  </article>

  <section class="other">
    {foreach from=$games item=game}
      <article>
        <h1>
          <a href="{url to='/ads/by_game' id=$game->id}">
            {$game->name}
          </a>
        </h1>
        <div class="category">{$game->game_category->name}</div>
        {image_path image=$game->cover_image}
        <section class="description">{$game->description|truncate:450}</section>
      </article>
    {/foreach}
  </section>

</section>

{/block}
