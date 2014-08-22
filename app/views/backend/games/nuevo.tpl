{extends 'backend.tpl'}

{block name=content}

<h1>New game</h1>

<form
  action="{url to='/backend/games/create' id=$game->id}"
  enctype="multipart/form-data"
  method="POST">

  {image_path image=$game->cover_image}
  <input type="hidden" name="MAX_FILE_SIZE" value="300000000">
  <input name="cover_image" type="file">

  <label for="name">Name</label>
  <input name="name" type="text" value="{$game->name}">

  <label for="release_date">Release date</label>
  <input name="release_date" type="text" value="{$game->release_date}">

  <label for="software_house">Software house</label>
  <input name="software_house" type="text" value="{$game->software_house}">

  <label for="description">Description</label>
  <textarea name="description" cols="30" rows="10"></textarea>

  <input type="submit" value="Create game">
</form>

{/block}
