<tr>
  {assign author $ad->author}

  <td>
    {$author->full_name()}
    (<a href="mailto:{$author->email}">{$author->email}</a>)
  </td>
  <td>{$ad->console->name}</td>

  {if isset($ad->game)}
    <td>{$ad->game->name}</td>
  {else}
    <td>{$ad->accessory->name}</td>
  {/if}

  <td>{$ad->published_at|date_format:"%b %e, %Y - %H:%M"}</td>

  <td class="actions">
    <a class="show" href="{url to='/ads/show' id=$ad->id}">Show</a>

    <a class="destroy" data-confirm href="{url to='/backend/ads/destroy' id=$ad->id}">
      Delete
    </a>
  </td>
</tr>
