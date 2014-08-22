<tr>
  <td>{$game->name}</td>
  <td>{$game->console->name}</td>
  <td>{$game->release_date}</td>
  <td>{$game->software_house}</td>
  <td>{$game->description|truncate}</td>

  <td class="actions">
    <a href="{url to='/backend/games/edit' id=$game->id}">Edit</a>

    <a
      data-confirm="Are you sure? All ads for this game will be deleted."
      href="{url to='/backend/games/destroy' id=$game->id}">
      Delete
    </a>
  </td>
</tr>
