{extends 'backend.tpl'}

{block name=content}

<h1>New accessory</h1>

<form
  action="{url to='/backend/accessories/create' id=$accessory->id}"
  enctype="multipart/form-data"
  method="POST">

  {image_path image=$accessory->image}
  <input type="hidden" name="MAX_FILE_SIZE" value="300000000">
  <input name="image" type="file">

  <label for="name">Name</label>
  <input name="name" type="text" value="{$accessory->name}">

  <label for="release_date">Release date</label>
  <input name="release_date" type="date" value="{$accessory->release_date}">

  <label for="producer">Producer</label>
  <input name="producer" type="text" value="{$accessory->producer}">

  <label for="description">Description</label>
  <textarea name="description" rows="10"></textarea>

  <label for="console_id">Console</label>
  {html_options name=console_id options=$consoles_for_select selected=$accessory->console_id}

  <input type="submit" value="Create accessory">
</form>

{/block}
