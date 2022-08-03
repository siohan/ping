{if $itemcount > 0}
<h3>Classement général {if isset($libequipe)} en {$libequipe}{/if}</h3>

<table border="0" cellspacing="0" cellpadding="0" class="table pagetable">
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