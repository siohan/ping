{if $itemscount>0}
<p>La première colonne est celle du spid, la deuxième FFTT</p>
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
	<thead>
		<tr>
			<th>Id</th>
			<th>Date</th>
			<th>Licence </th>
			<th>Licence</th>
			<th>Nom</th>
			<th>Nom</th>
			<th>N° Journée</th>
			<th>N° Journée</th>
			<th>Victoire</th>
			<th>Victoire</th>
			<th>Coeff</th>
			<th>Coeff</th>
			<th>Points</th>
			<th>Points</th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$items item=entry}
		<tr class="{$entry->rowclass}">
			<td>{$entry->id}</td>
			<td>{$entry->date_event|date_format:"%d/%m"}</td>
			<td>{$entry->licence_spid}</td>
			<td>{$entry->licence_fftt}</td>
			<td>{$entry->nom_spid}</td>
			<td>{$entry->nom_fftt}</td>
			<td>{$entry->numjourn_spid}</td>
			<td>{$entry->numjourn_fftt}</td>
			<td{if $entry->victoire_spid != $entry->victoire_fftt} style="background-color: red;"}{/if}> 				{$entry->victoire_spid}</td>
			<td>{$entry->victoire_fftt}</td>
			<td{if $entry->coeff_spid != $entry->coeff_fftt} style="background-color: red;"}{/if}>{$entry->coeff_spid}</td>
			<td>{$entry->coeff_fftt}</td>
			<td{if $entry->points_spid != $entry->points_fftt} style="background-color: red;"}{/if}>{$entry->points_spid}</td>
			<td>{$entry->points_fftt}</td>
			<td>{$entry->eraselink}</td>
			
		</tr>
	{/foreach}
	</tbody>
			
			
</table>
{else}
<p>Aucune erreur {$returnlink}</p>
{/if}