{extends 'skeleton.tpl'}

{block name=container}

<div class="single-ad">
  <header>
    <h1>
      <a href="{$site_root}/games/show?name={$ad.game.name}">{$ad.game.name}</a>
    </h1>
    <div class="price">{$ad.price}€</div>
    <div class="city">{$ad.city}</div>
  </header>

  <section class="description">{$ad.description}</section>
</div>

{/block}
