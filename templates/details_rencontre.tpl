{*<pre>{$items|var_dump}</pre>*}
{*<pre>{$prods_2|var_dump}</pre>*}
{if $parameters == 1}
<h3>Les résultats du 1 {$date_event}</h3>
	<table id="resultats" class="table table-bordered">
{foreach from=$items  item=entry}

	
							<tr><td>{$entry->equa}</td><td>{$entry->scorea}</td><td>{$entry->scoreb}</td><td>{$entry->equb}</td>{if $entry->uploaded =='1'}<td>{$entry->details} {$entry->class}</td>{/if}</tr>
			{/foreach}
		</table>
	
{else}
<!-- début du deuxième gabarit-->
{* ceci est le gabarit pour les autres conditions *}
{foreach from=$items  item=entry}

	<h3>Les résultats du {$entry->date_event|date_format:"%d/%m/%Y"}</h3>
		<table id="tableau" class="table table-bordered">
			{foreach from=$prods_{$entry->valeur} item=donnee}
				<tr><td>{$donnee->equa}</td><td>{$donnee->scorea}</td><td>{$donnee->scoreb}</td><td>{$donnee->equb}</td>{if $donnee->uploaded == '1'}<td>{$donnee->details}</td>{/if}</tr>
			{/foreach}
		</table>
	
{/foreach}
{/if}
