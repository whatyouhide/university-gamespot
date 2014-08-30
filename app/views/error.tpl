{extends 'skeleton.tpl'}

{block name=title}Error - Gamespot{/block}
{block name=html_class}error{/block}

{block name=container}
  <div class="error-container">
    <h3>Error</h3>
    {block name=content}Default error content.{/block}
    <div class="links">
      <a data-back>back</a>
      /
      <a href="{url to='/'}">homepage</a>
    </div>
  </div>
{/block}
