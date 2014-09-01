{extends 'frontend.tpl'}

{block name=content}

<section class="all">

  <article class="with-most-ads">
    <a href="{url to='/ads/by_accessory' id=$accessory_with_most_ads->id}">
      <h1>★ Accessory with most ads ★</h1>
      <h2>{$accessory_with_most_ads->name}</h2>
      <div class="infos">
        <div class="number">
          <span>{$accessory_with_most_ads->ads_count}<span>
          ads
        </div>
      </div>
    </a>
  </article>

  <section class="other">
    {foreach from=$accessories item=accessory}
      <article>
        <a
          href="{url to='/accessories/subscribe' id=$accessory->id}"
          data-tooltip
          aria-haspopup="true"
          title="Subscribe to get notifications when ads about this accessory are published"
          class="has-tip subscribe">
          Subscribe
        </a>
        <h1>
          <a href="{url to='/ads/by_accessory' id=$accessory->id}">
            {$accessory->name}
          </a>
        </h1>
        {image_path image=$accessory->image}
        <section class="description">{$accessory->description|truncate:450}</section>
      </article>
    {/foreach}
  </section>

</section>

{/block}
