<!DOCTYPE html>
<html>

<head>
  <title>Gamespot</title>
  <meta charset="utf-8">
</head>

<body>
  <div id="container">
    <div class="flashes">
      {foreach from=$flash key=type item=msg}
        <p class="{$type}">{$msg}</p>
      {/foreach}
    </div>

    {block name=container}Default container.{/block}
  </div>
</body>

</html>
