{if $itemcount > 0}
<a href="{cms_action_url action='add_edit_contacts'}">{admin_icon icon="edit.gif"} Modifier</a><a href="{cms_action_url action='retrieve'  retrieve=details_club}">{admin_icon icon="import.gif"} Importer depuis la FFTT</a>
<h3>Coordonnées de la salle</h3>
<ul>
{foreach from=$items item=entry}  
	<li>{$entry->nom}</li>
    <li>{$entry->adressesalle1} {$entry->adressesalle2}</li>
    <li>{$entry->codepsalle} - {$entry->villesalle}</li>
	<li>Lat : {$entry->lat}</li>
	<li>Long : {$entry->lng}</li>
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