{extends 'skeleton.tpl'}

{block name=container}
  {include file='partials/flashes.tpl'}
  {include file='partials/backend/menu.tpl'}

  <div id="content">
    {block name=content}Default backend content.{/block}
  </div>
{/block}
