{extends 'backend.tpl'}

{block name=content}

<section class="wrapper">
  <h1>Consoles</h1>
  <table class="consoles">
    <thead>
      <th>Name</th>
      <th>Release year</th>
      <th>Producer</th>
      <th>Actions</th>
    </thead>

    <tbody>
      {foreach from=$consoles item=console}
        {include file='backend/consoles/_console_row.tpl'}
      {/foreach}
    </tbody>
  </table>

  <a class="new-item" href="{url to='/backend/consoles/nuevo'}">New console</a>
</section>

{/block}
