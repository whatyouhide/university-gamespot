{extends 'backend.tpl'}

{block name=content}

<section class="wrapper">
  <h1>Ads</h1>

  <table class="ads">
    <thead>
      <th>Author</th>
      <th>Console</th>
      <th>Game/accessory</th>
      <th>Published at</th>
      <th>Actions</th>
    </thead>

    <tbody>
      {foreach from=$ads item=ad}
        {include file='backend/ads/_ad_row.tpl'}
      {/foreach}
    </tbody>
  </table>
</section>

{/block}
