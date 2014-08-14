{extends 'skeleton.tpl'}

{block name=container}

<div class="single-ad">
  <header>
    <h1>
      <a href="{$site_root}/games/show?name={$ad.game.name}">{$ad.game.name}</a>
      <img src="{$uploads}/{$ad.game.cover_image}">
    </h1>
    <div class="price">{$ad.price}€</div>
    <div class="city">{$ad.city}</div>
  </header>

  <section class="description">{$ad.description}</section>
</div>

<section class="contact">
  <h1>Send a message to the seller</h1>

  <form action="{$site_root}/ads/contact" method="POST">
    {if !$current_user}
      <input type="name" placeholder="Your name">
      <input type="email" placeholder="Your email">
    {/if}

    <textarea name="message" placeholder="Your message goes here."></textarea>
  </form>
</section>

{/block}
