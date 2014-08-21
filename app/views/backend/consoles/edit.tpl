{extends 'backend.tpl'}

{block name=content}

<h1>Edit console</h1>

<form action="{url to='/backend/consoles/update' id=$console->id}" method="POST">
  <label for="name">Name</label>
  <input name="name" type="text" value="{$console->name}">

  <label for="release_year">Release year</label>
  <input name="release_year" type="number" value="{$console->release_year}">

  <label for="producer">Producer</label>
  <input name="producer" type="text" value="{$console->producer}">

  <input type="submit" value="Update console">
</form>

{/block}
