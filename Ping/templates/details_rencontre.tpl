{*<pre>{$items|var_dump}</pre>*}
{*<pre>{$entrees|var_dump}</pre>*}

{foreach from=$items  item=entry}

	<h3>Les résultats du {$entry->date_event}</h3>
		<table class="table table-bordered">
			{foreach from=$prods_{$entry->valeur} item=donnee}
				<tr><td>{$donnee->equa}</td><td>{$donnee->scorea}</td><td>{$donnee->scoreb}</td><td>{$donnee->equb}</td><td>{$donnee->details}</td></tr>
			{/foreach}
		</table>
	
{/foreach}
