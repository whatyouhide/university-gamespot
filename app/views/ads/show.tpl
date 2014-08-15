{extends 'skeleton.tpl'}

{block name=container}

<div class="single-ad">
  <header>
    <h1>
      <a href="{$site_root}/games/show?name={$ad.game.name}">{$ad.game.name}</a>
    </h1>
    <img src="{$uploads}/{$ad.game.cover_image}">
    <div class="price">{$ad.price}€</div>
    <div class="city">{$ad.city}</div>
  </header>

  <section class="description">{$ad.description}</section>
</div>

<section class="contact">
  <h1>Send a message to the seller</h1>

  <form action="{$site_root}/ads/contact" method="POST">
    <input name="ad_id" type="hidden" value="{$ad.id}">

    {if !$current_user}
      <input name="name" type="name" placeholder="Your name">
      <input name="sender_email" type="email" placeholder="Your email">
    {/if}

    <textarea name="message" placeholder="Your message goes here."></textarea>
    <input type="submit" value="Send">
  </form>
</section>

{/block}
