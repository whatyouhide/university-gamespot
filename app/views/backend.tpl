{extends 'skeleton.tpl'}

{block name=container}
  {include file='partials/backend/menu.tpl'}

  <div id="content">
    {include file='partials/flashes.tpl'}
    {block name=content}Default backend content.{/block}
  </div>
{/block}
