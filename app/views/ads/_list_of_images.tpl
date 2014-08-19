<ul class="images">
  {foreach from=$images item=image}
    {image_path image=$image}
    <a href="{$site_root}/ads/remove_image?id={$ad->id}&image_id={$image->id}">Rimuovi</a>
  {/foreach}
</ul>
