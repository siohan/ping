
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
<div class="pageoptions"><p class="pageoptions">{$create_new_contact}</p></div>
{if $itemcount > 0}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>{$id}</th>
		<th>Type de contact</th>
		<th>contact</th>
		<th>description</th>
		<th colspan='3'>Actions</th>
	</tr>
</thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->id}</td>
	<td>{$entry->type_contact}</td>
    <td>{$entry->contact}</td>
	<td>{$entry->description}</td>
	<td>{$entry->create_contact}</td>
		<td>{$entry->deletelink}</td>
    </tr>
{/foreach}
 </tbody>
</table>
{else}
<p>{$create_new_contact}</p>
{/if}

