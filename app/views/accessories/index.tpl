{extends 'frontend.tpl'}

{block name=content}

<section class="all-accessories">

  <article class="with-most-ads">
    <h1>Accessory with most ads</h1>
    <h2>{$accessory_with_most_ads->name}</h2>
    <div class="number">
      <span>{$accessory_with_most_ads->ads_count}<span>
      ads
    </div>
    <a href="{url to='/ads/by_accessory' id=$accessory_with_most_ads->id}">See ads</a>
  </article>

  {foreach from=$accessories item=accessory}
    <article>
      <h1>
        <a href="{url to='/ads/by_accessory' id=$accessory->id}">
          {$accessory->name}
        </a>
      </h1>
      {image_path image=$accessory->image}
      <section class="description">{$accessory->description}</section>
    </article>
  {/foreach}

</section>

{/block}
