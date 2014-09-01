<tr>
  <td>{$console->name}</td>
  <td>{$console->release_year}</td>
  <td>{$console->producer}</td>

  <td class="actions">
    <a class="edit" href="{url to='/backend/consoles/edit' id=$console->id}">Edit</a>

    <a
      class="destroy"
      data-confirm="Are you sure? All games and accessories for this console will be deleted."
      href="{url to='/backend/consoles/destroy' id=$console->id}">
      Delete
    </a>
  </td>
</tr>
