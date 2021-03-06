{if isset($backend) && $backend}
  {assign html_class "backend"}
{else}
  {assign html_class "frontend"}
{/if}

<!DOCTYPE html>
<html
  class="{$html_class} {block name=html_class}{/block}"
  data-site-root="{$site_root}"
  lang="en"
  >

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="{url to='/favicon.ico'}" >

  <title>{block name=title}Gamespot{/block}</title>

  {include file='partials/stylesheets.tpl'}

  <script src="{$lib}/javascripts/modernizr.js"></script>
</head>

<body class="{$controller_name} {$controller_action}">
  <div id="container">
    {block name=container}Default container.{/block}
  </div>

  {include file='partials/javascripts.tpl'}
</body>

</html>
