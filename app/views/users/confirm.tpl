{extends 'frontend.tpl'}

{block name=content}
{if $confirmed}
  <h1>Great</h1>
  <p>
    Want to go back to the
    <a href="{url to='/users/sign_in'}">Sign in page</a>
    ?
  </p>
{else}
  <h1>Oooops</h1>
  <p>You could't be confirmed.</p>
{/if}
{/block}
