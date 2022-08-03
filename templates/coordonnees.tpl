{if $itemcount > 0}
<h3>Coordonnées de la salle</h3>
<ul>
{foreach from=$items item=entry}  
	<li>{$entry->nom}</li>
    <li>{$entry->adressesalle1} {$entry->adressesalle2}</li>
    <li>{$entry->codepsalle} - {$entry->villesalle}</li>
{/foreach}
</ul>
<h3>Coordonnées du correspondant</h3>
<ul>
{foreach from=$items item=entry}  
	<li>{$entry->prenomcor} {$entry->nomcor}</li>
    <li>{$entry->mailcor}</li>
    <li>{$entry->telcor}</li>
{/foreach}
</ul>
{/if}

