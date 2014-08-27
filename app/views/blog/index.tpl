{extends 'frontend.tpl'}
{block name=content}

<section class="posts">
  {foreach from=$posts item=post}
    <article>
      <h1><a href="{url to='/blog/post' id=$post->id}">{$post->title}</a></h1>
      <div data-ago="{$post->published_at}" class="published-at"></div>
      <div class="author-name">by {$post->author->full_name()}</div>
      <div class="excerpt">
        {$post->excerpt}
      </div>
    </article>
  {/foreach}
</section>

{/block}
