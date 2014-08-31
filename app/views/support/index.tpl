{extends 'frontend.tpl'}

{block name=content}

<h1>We're here for you.</h1>

<p>Feel free to open a new ticket if there's a problem.</p>

<form action="{url to='/support/create_ticket'}" method="POST">
  <label for="title">Title</label>
  <input name="title" type="text">

  <label for="content">Content</label>
  <textarea name="content"></textarea>

  <label for="topic">Topic</label>
  {html_options name=topic options=$topics}

  <input type="submit" value="Request support">
</form>

{/block}
