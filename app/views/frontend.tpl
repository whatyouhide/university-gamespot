{extends 'skeleton.tpl'}

{block name=container}
  {include file='partials/frontend/header.tpl'}
  {include file='partials/flashes.tpl'}

  <div id="content">
    {block name=content}Default content.{/block}
  </div>
{/block}
