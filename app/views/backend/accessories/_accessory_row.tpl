<tr>
  <td>{$accessory->name}</td>
  <td>{$accessory->release_date}</td>
  <td>{$accessory->console->name}</td>
  <td>{$accessory->producer}</td>
  <td>{$accessory->description|truncate:40}</td>


  <td class="actions">
    <a class="edit" href="{url to='/backend/accessories/edit' id=$accessory->id}">Edit</a>

    <a
      class="destroy"
      data-confirm="Are you sure? All ads for this accessory will be deleted."
      href="{url to='/backend/accessories/destroy' id=$accessory->id}">
      Delete
    </a>
  </td>
</tr>
