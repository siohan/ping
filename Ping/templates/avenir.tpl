{*<pre>{$items|var_dump}</pre>*}
{assign var=compteur value = 0}

<ul>
{foreach from=$items item=entry}
{*<p><pre>{$prods_{$compteur++}|var_dump}</pre></p>*}
<li>{*$entry->valeur*}{if $entry->indivs==0}{$entry->date|date_format:"%d/%m/%Y"} {$entry->compet}
	<ul>
		{foreach from=$prods_{$entry->valeur} item=donnee}
			<li> {$donnee->equa} - {$donnee->equb}</li>
		{/foreach}
	</ul>
{else}{$entry->date|date_format:"%d/%m/%Y"} {$entry->compet}{/if}</li>
{/foreach}
</ul>