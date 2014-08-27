{extends 'frontend.tpl'}
{block name=content}

<div class="post">
  <h1>{$post->title}</h1>

  <div class="author-name">by {$post->author->full_name()}</div>

  <div class="date">
    <p>
      Published <b data-ago="{$post->published_at}"></b> on
      {$post->published_at|date_format:'%b %d %Y'}
    </p>

  <section class="excerpt">{$post->excerpt}</section>
  <section class="content">{$post->content}</section>
</div>

{/block}
