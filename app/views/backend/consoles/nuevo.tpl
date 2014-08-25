{extends 'backend.tpl'}

{block name=content}

<h1>New console</h1>

<form
  enctype="multipart/form-data"
  method="POST"
  action="{url to='/backend/consoles/create'}">

  <label for="console_image">Image</label>
  <input type="hidden" name="MAX_FILE_SIZE" value="300000000">
  <input name="console_image" type="file">

  <label for="name">Name</label>
  <input name="name" type="text">

  <label for="release_year">Release year</label>
  <input name="release_year" type="number">

  <label for="producer">Producer</label>
  <input name="producer" type="text">

  <input type="submit" value="Create console">
</form>

{/block}
