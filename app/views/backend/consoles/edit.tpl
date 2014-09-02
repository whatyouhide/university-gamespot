{extends 'backend.tpl'}

{block name=content}

<section class="wrapper">
  <h1>Edit console</h1>

  <form
    action="{url to='/backend/consoles/update' id=$console->id}"
    enctype="multipart/form-data"
    method="POST">

    {image_path image=$console->image}
    <input type="hidden" name="MAX_FILE_SIZE" value="300000000">
    <input name="console_image" type="file">

    {if $console->image}
      <button data-hijack>Remove</button>
    {/if}

    <label for="name">Name</label>
    <input name="name" type="text" value="{$console->name}">

    <label for="release_year">Release year</label>
    <input name="release_year" type="number" value="{$console->release_year}">

    <label for="producer">Producer</label>
    <input name="producer" type="text" value="{$console->producer}">

    <input type="submit" value="Update console">
  </form>
</section>

{/block}
