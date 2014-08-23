{extends 'backend.tpl'}

{block name=content}

<h1>New game</h1>

<form
  action="{url to='/backend/games/create' id=$game->id}"
  enctype="multipart/form-data"
  method="POST">

  {image_path}
  <input type="hidden" name="MAX_FILE_SIZE" value="300000000">
  <input name="cover_image" type="file">

  <label for="name">Name</label>
  <input name="name" type="text">

  <label for="release_date">Release date</label>
  <input name="release_date" type="text">

  <label for="software_house">Software house</label>
  <input name="software_house" type="text">

  <label for="description">Description</label>
  <textarea name="description" cols="30" rows="10"></textarea>

  <label for="console_id">Console</label>
  {html_options name=console_id options=$consoles_for_select}

  <label for="game_category_id">Category</label>
  {html_options name=game_category_id options=$game_categories_for_select}

  <input type="submit" value="Create game">
</form>

{/block}
