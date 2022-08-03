{foreach from=$items  item=entry}

		<table id="wp-calendar" class="sp-calendar sp-event-calendartable sp-data-table table-bordered">
			<caption class="sp-table-caption">Les résultats du {$entry->date_event|date_format:"%d/%m/%Y"}</caption>
			{foreach from=$prods_{$entry->valeur} item=donnee}
				<tr><td>{$donnee->equa}</td><td>{$donnee->scorea}</td><td>{$donnee->scoreb}</td><td>{$donnee->equb}</td>{if true == $donnee->uploaded}<td>{$donnee->details}</td>{/if}</tr>
			{/foreach}
		</table>
	
{/foreach}