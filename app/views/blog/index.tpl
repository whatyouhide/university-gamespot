{extends 'frontend.tpl'}
{block name=content}

{if $filtered}
  <h1>Filtered with tag: {$tag->name}</h1>
  <div><a href="{url to='/blog'}">All articles</a>
{/if}

<section class="posts">
  {foreach from=$posts item=post}
    <article>
      <h1><a href="{url to='/blog/post' id=$post->id}">{$post->title}</a></h1>
      <div data-ago="{$post->published_at}" class="published-at"></div>
      <div class="author-name">by {$post->author->full_name()}</div>
      {include 'blog/_list_of_tags.tpl'}
      <div class="excerpt">
        {$post->excerpt}
      </div>
    </article>
  {/foreach}
</section>

{/block}
