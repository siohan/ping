{if $itemcount > 0}

{foreach from=$items item=entry}
{*<pre>{$items|var_dump}</pre>*}
<h3>Résultats du {$entry->libelle}</h3>	
<p>{if isset($tableau) && $tableau == $entry->tableau}<a href="{cms_action_url action=indivs record_id=$record_id}">Joueurs du club uniquement</a>{else}<a href="{cms_action_url action=indivs record_id=$record_id tableau=$entry->tableau}">Classement intégral ?</a>{/if}</p>
{if $itemscount_{$entry->valeur} >0}
  	<table class="table table-bordered">
		<thead>
                   <tr>
                     <th>Place</th>
                     <th>Nom</th>
{if isset($tableau)} <th>Club</th>{/if}
                   </tr>
                </thead>
                <tbody>
               {foreach from=$prods_{$entry->valeur} item=donnee}
			<tr>
				<td>{$donnee->rang}</td>
				<td>{$donnee->nom}</td>
                       {if isset($tableau)}<td>{$donnee->club}</td>{/if}
			</tr>
		{/foreach}
               </tbody>
             </table>
		{**}
		{else}
		<p>Pas encore de résultats !</p>
		{/if}{**}
{/foreach}
 
{/if}
