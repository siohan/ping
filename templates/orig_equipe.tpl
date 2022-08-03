<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount > 0}
<h3>Classement général {$libequipe}</h3>
<table border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
 <thead>
	<tr>
		<th>Clt</th>
		<th>Equipe</th>
		<th>Joués</th>
		<th>G</th>
		<th>N</th>
		<th>P</th>
		<th>PG</th>
		<th>PP</th>
		<th>PF</th>
		<th>Pts</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->clt}</td>
    <td>{$entry->equipe}</td>
    <td>{$entry->joue}</td>
	<td>{$entry->vic}</td>
	<td>{$entry->nul}</td>
	<td>{$entry->def}</td>
	<td>{$entry->pg}</td>
	<td>{$entry->pp}</td>
	<td>{$entry->pf}</td>
	<td>{$entry->pts}</td>
    
  </tr>
{/foreach}
 </tbody>
</table>
{/if}
{if $itemcount2 > 0}
{foreach from=$items2 item=entry}
{*<pre>{$items2|var_dump}</pre>*}
<h3>Résultats du {$entry->date_event|date_format:"%d/%m"}</h3>	
{if $itemscount_{$entry->valeur} >0 }
  	<table class="table table-bordered">
		{foreach from=$prods_{$entry->valeur} item=donnee}
			<tr>
				<td>{$donnee->equa}</td>
				<td>{$donnee->scorea}</td>
				<td>{$donnee->scoreb}</td>
				<td>{$donnee->equb}</td>
				{if true == $donnee->uploaded}<td>{$donnee->details}</td>{/if}
			</tr>
		{/foreach}
		</table>
		
		{else}
		<p>Pas encore de résultats !</p>
		{/if}
{/foreach}
 </tbody>
</table>
{/if}
