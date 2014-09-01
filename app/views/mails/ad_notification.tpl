{extends 'mail_skeleton.tpl'}

{block name=content}
A {$ad->type} ad about <b>{$name}</b> has been created/updated.
<br>
<br>
You can have a look at it
<a href="{url to='/ads/show' id=$ad->id absolute=true}">here</a>
.
{/block}
