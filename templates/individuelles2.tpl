{*<pre>{$items|var_dump}</pre>*}
{*<pre>{$prods_1|var_dump}</pre>*}
<div class="pageoptions"><p class="pageoptions">{$returnlink}</p></div>
{*<div class="pageoptions"><p class="pageoptions" style="float: right">{$indivs_courant}</p></div>*}
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>


		{foreach from=$items  item=entry}

			<h3>{$entry->libelle}</h3>
				<table class="table table-bordered">
					{foreach from=$prods_{$entry->valeur} item=donnee}
						<tr>
							<td>{$donnee->rang}</td>
							<td>{$donnee->nom}</td>
							<td>{$donnee->club}</td>
						</tr>
					{/foreach}
				</table>

		{/foreach}
	</tbody>
 </table>