<!-- Ping Contacts template par défaut -->
<ul>
{foreach from=$items item=entry}
 
	<li>{$entry->nom}</li>
    <li>{$entry->nomsalle}</li>
    <li>{$entry->adressesalle1}</li>
	<li>{$entry->adressesalle2}</li>
	<li>{$entry->codepsalle}</li>
	<li>{$entry->villesalle}</li>
	<li>{$entry->web}</li>
	<li>{$entry->nomcor}</li>
	<li>{$entry->prenomcor}</li>
	<li>{$entry->mailcor}</li>
	<li>{$entry->telcor}</li>
	<li>{$entry->lat}</li>
	<li>{$entry->lng}</li>
    
{/foreach}
</ul>
