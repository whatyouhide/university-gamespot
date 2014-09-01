{extends 'frontend.tpl'}
{block name=content}

<header class="site-name-and-description">
  <h1>{image_path src='logo.png' hoverable=true}</h1>
  <h3>A platform for buying and selling used videogames and accessories.</h3>
</header>

<section class="latests">
  <article class="ad">
    <a href="{url to='/ads/show' id=$latest_ad->id}">
      <h3>Latest ad</h3>
      {$type=$latest_ad->type}
      <h1>{$type|ucfirst} ad</h1>
      <h2>{$latest_ad->$type->name}</h2>

      {image_path image=$latest_ad->main_image()}
    </a>
  </article>

  <article class="game">
    <a href="{url to='/ads/by_game' game_id=$latest_game->id}">
      <h3>Latest game</h3>
      <h1>{$latest_game->name}</h1>
      {image_path image=$latest_game->cover_image}
    </a>
  </article>

  <article class="accessory">
    <a href="{url to='/ads/by_accessory' id=$latest_accessory->id}">
      <h3>Latest accessory</h3>
      <h1>{$latest_accessory->name}</h1>
      {image_path image=$latest_accessory->image}
    </a>
  </article>
</section>

{/block}
