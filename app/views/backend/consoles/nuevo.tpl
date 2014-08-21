{extends 'backend.tpl'}

{block name=content}

<h1>New console</h1>

<form action="{url to='/backend/consoles/create'}">
  <label for="name">Name</label>
  <input name="name" type="text">

  <label for="release_year">Release year</label>
  <input name="release_year" type="number">

  <label for="producer">Producer</label>
  <input name="producer" type="text">

  <input type="submit" value="Create console">
</form>

{/block}
