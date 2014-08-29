{extends 'backend.tpl'}
{block name=content}

<h1>Posts</h1>

<section class="posts">
  {foreach from=$posts item=post}
    {if $post->is_published()}
      {$status=published}
    {else}
      {$status=draft}
    {/if}

    {if $post->author_id eq $current_user->id}
      {$mine='mine'}
    {else}
      {$mine=''}
    {/if}

    <article class="{$status} {$mine}">
      <h1>{$post->title}</h1>
      <h2>{$status}</h2>

      <div class="tags">
        {foreach from=array_pluck($post->tags, 'name') item=tag_name name=tags}
          {assign not_last !$smarty.foreach.tags.last}
          <span>{$tag_name}</span>{if $not_last},{/if}
        {/foreach}
      </div>

      <div class="excerpt">{$post->excerpt}</div>

      <div class="actions">
        <a href="{url to='/backend/posts/edit' id=$post->id}">Edit</a>
        <a data-confirm href="{url to='/backend/posts/destroy' id=$post->id}">
          Delete
        </a>
      </div>
    </article>
  {/foreach}
</section>

<a href="{url to='/backend/posts/nuevo'}">New post</a>

{/block}
