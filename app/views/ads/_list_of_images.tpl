<ul class="images">
  {foreach from=$images item=image}
    <li>
      {image_path image=$image}
      <a data-confirm class="remove-image" href="{$site_root}/ads/remove_image?id={$ad->id}&image_id={$image->id}">Remove</a>
    </li>
  {/foreach}
</ul>
