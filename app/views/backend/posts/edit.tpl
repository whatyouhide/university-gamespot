{extends 'backend.tpl'}

{block name=content}

{if $post->is_published()}
  {$status=published}
{else}
  {$status=draft}
{/if}

<section class="wrapper">
  <h1>Edit post</h1>
  <h2 class="status {$status}">Status: {$status}</h2>

  <form
    action="{url to='/backend/posts/update' id=$post->id}"
    method="POST"
    enctype="multipart/form-data">

    <input name="published" type="hidden" value="{$post->published}">

    <label for="title">Title</label>
    <input name="title" type="text" value="{$post->title}">

    <label for="excerpt">Excerpt</label>
    <textarea maxlength="250" name="excerpt">{$post->excerpt}</textarea>

    <label for="content">Content</label>
    <textarea class="froala" name="content">{$post->content}</textarea>

    <label for="tags[]">Tags</label>
    <select name="tags[]" multiple data-selectize>
      {foreach from=$tags item=tag}
        {if in_array($tag->id, array_pluck($post->tags, 'id'))}
          {$selected=selected}
        {else}
          {$selected=''}
        {/if}

        <option value="{$tag->name}" {$selected}>{$tag->name}</option>
      {/foreach}
    </select>

    <input class="save-button" type="submit" value="Save">
  </form>

  <form
    action="{url to='/backend/posts/toggle_published' id=$post->id}"
    method="POST">

    {if $post->is_published()}
      {$action=Unpublish}
    {else}
      {$action=Publish}
    {/if}

    <input class="publish-unpublish" type="submit" data-confirm value="{$action}">
  </form>
</section>

{/block}
