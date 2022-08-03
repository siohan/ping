{if $itemcount >0}
<h1 class="widget-title">Classements</h1>	
<table class="table pagetable">
 <thead>
	<tr>
		<th>Clt</th>
		<th>Eq</th>
		<th>J</th>
		<th>G</th>
		<th>N</th>
		<th>P</th>
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
	<td>{$entry->pts}</td>    
  </tr>
{/foreach}
 </tbody>
</table>
{/if}