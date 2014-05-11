{extends 'skeleton.tpl'}

{block name=container}

<div class="flash">{$smarty.get.flash_message}</div>

<h1 class="welcome">Welcome {$smarty.session.user.first_name}</h1>

<section class="create-ads">
  <a href="{$site_root}/ads/nuevo?type=accessory">Create accessory ad</a>
  <a href="{$site_root}/ads/nuevo?type=game">Create game ad</a>
</section>

{/block}
