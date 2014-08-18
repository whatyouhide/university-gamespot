{extends 'frontend.tpl'}

{block name=content}
<div class="all-accessories">
  {foreach from=$accessories item=accessory}
    <article>
      <h1>{$accessory->name}</h1>
      {image_path image=$accessory->image}
      <section class="description">{$accessory->description}</section>
    </article>
  {/foreach}
</div>
{/block}
