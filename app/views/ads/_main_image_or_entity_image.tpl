{if $ad->main_image()}
  {image_path image=$ad->main_image()}
{else}
  {image_path image=$entity_image}
{/if}
