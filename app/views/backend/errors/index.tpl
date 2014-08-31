{extends 'backend.tpl'}

{block name=content}
<h1>Errors</h1>

<div class="disclaimer">
  <p>
    This is a list of errors intended for rapidly
    communicating with the developers of the website.
  </p>
</div>

<table>

<thead>
  <th>Number</th>
  <th>Message</th>
  <th>Happened at</th>
</thead>

<tbody>
  {foreach from=$errors item=error}
    <tr>
      <td>{$error->id}</td>
      <td>{$error->message}</td>
      <td>{$error->happened_at}</td>
    </tr>
  {/foreach}
</tbody>

</table>
{/block}
