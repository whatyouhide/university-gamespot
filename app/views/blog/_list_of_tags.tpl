<div class="tags">
  {foreach from=$post->tags item=tag name=tags}
    {$last=$smarty.foreach.tags.last}
    <a href="{url to='/blog/by_tag' tag_name=$tag->name}">{$tag->name}</a>{if !$last}, {/if}
  {/foreach}
</div>
