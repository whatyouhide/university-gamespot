<!DOCTYPE html>
<html>

<head>
  <title>Gamespot</title>
  <meta charset="utf-8">
  {include file='partials/javascripts.tpl'}
</head>

<body class="{$controller_name} {$controller_action}">
  <div id="container">
    {include file='partials/flashes.tpl'}
    {block name=container}Default container.{/block}
  </div>
</body>

</html>
