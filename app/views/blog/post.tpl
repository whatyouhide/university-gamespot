{extends 'frontend.tpl'}
{block name=content}

<article class="post">
  <h1>{$post->title}</h1>

  <div class="author-name">by {$post->author->full_name()}</div>

  <div class="date">
    <p>
      Published <b data-ago="{$post->published_at}"></b> on
      {$post->published_at|date_format:'%b %d %Y'}
    </p>
  </div>

  {include 'blog/_list_of_tags.tpl'}

  <section class="excerpt">{$post->excerpt}</section>
  <section class="content">{$post->content}</section>
</article>

{/block}
