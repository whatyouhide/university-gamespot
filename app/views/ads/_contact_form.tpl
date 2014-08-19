<section class="contact">
  <h1>Send a message to the seller</h1>

  <form action="{$site_root}/ads/contact" method="POST">
    <input name="ad_id" type="hidden" value="{$ad->id}">

    {if !$current_user}
      <input name="name" type="name" placeholder="Your name">
      <input name="sender_email" type="email" placeholder="Your email">
    {/if}

    <textarea name="message" placeholder="Your message goes here."></textarea>
    <input type="submit" value="Send">
  </form>
</section>
