{extends 'backend.tpl'}

{block name=content}

<h1>Edit game</h1>

<form
  action="{url to='/backend/games/update' id=$game->id}"
  enctype="multipart/form-data"
  method="POST">

  {image_path image=$game->cover_image}
  <input type="hidden" name="MAX_FILE_SIZE" value="300000000">
  <input name="cover_image" type="file">

  {if $game->cover_image}
    <button data-hijack>Remove</button>
  {/if}

  <label for="name">Name</label>
  <input name="name" type="text" value="{$game->name}">

  <label for="release_date">Release date</label>
  <input name="release_date" type="text" value="{$game->release_date}">

  <label for="software_house">Software house</label>
  <input name="software_house" type="text" value="{$game->software_house}">

  <label for="description">Description</label>
  <textarea name="description" rows="5">{$game->description}</textarea>

  <input type="submit" value="Update game">
</form>

{/block}
