{*<pre>{$items|var_dump}</pre>*}
{assign var=compteur value = 0}
<p style="width: 100%"><span style="text-align: left">{if $phase ==1}{$Sep} | {$Oct} | {$Nov} | {$Dec} {$mois_suivant}{else}{$mois_precedent}  {$Jan} | {$Fev} | {$Mar} | {$Avr} | {$Mai} | {$Juin} | {$Juil}{/if}</span><span style="float:right">{$all_results}</span></p>

{foreach from=$items item=entry}
{*<p><pre>{$prods_{$compteur++}|var_dump}</pre></p>*}

	{*$entry->valeur*}{*{if $entry->attention ==1}{$attention_img} ATTENTION !!  {/if}*}
	{if $entry->indivs==0}
	<h3>{$entry->date|date_format:"%d/%m/%Y"} {$entry->compet}</h3>
	
	
		<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
			{foreach from=$prods_{$entry->valeur} item=donnee}
				<tr>
					<td>{$donnee->equa}</td>
					<td>{$donnee->equb}</td>
					<td>{$donnee->scorea}</td>
					<td>{$donnee->scoreb}</td>
					<td>{$donnee->display}</td>
					<td>{$donnee->retrieve_poule_rencontres}</td>
					<td>{$donnee->retrieve_details}</td>
					<td>{$donnee->deletelink}</td>
				</tr>
				{/foreach}
			</table>
	
{else}
<h3>{$entry->date|date_format:"%d/%m/%Y"} {$entry->compet}</h3>

	<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
		<tr>
			<td>{$entry->download}</td>
		</tr>
	</table>

{/if}
{/foreach}
