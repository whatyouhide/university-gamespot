{extends 'backend.tpl'}

{block name=content}

<table class="games">
  <thead>
    <th>Name</th>
    <th>Console</th>
    <th>Release date</th>
    <th>Software house</th>
    <th>Description</th>
    <th>Actions</th>
  </thead>

  <tbody>
    {foreach from=$games item=game}
      {include file='backend/games/_game_row.tpl'}
    {/foreach}
  </tbody>
</table>

<a href="{url to='/backend/games/nuevo'}">New game</a>

{/block}
