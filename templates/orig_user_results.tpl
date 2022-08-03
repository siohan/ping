<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
<p>{$retour}</p>

<h3>Résumé des résultats de {$joueur}</h3>

<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <tbody>
	<thead>
		<tr>
			<th>Vic</th>
			<th>Total</th>
			<th>Pts</th>
		</tr>
	</thead>
 </tbody>
{foreach from=$items1 item=entree}
  <tr class="{$entree->rowclass}">
    <td>{$entree->vic}</td>
	<td>{$entree->total}</td>
	<td>{$entree->pts}</td>
  </tr>
{/foreach}
 </tbody>
</table>


		<h3>Le détail des résultats officiels de {$joueur}</h3>
		<table  class="table table-bordered">
		 <thead>
		  <tr>
			<th>Date</th>
			<th>Adv</th>
			<th>Vic/Def</th>
			<th>Pts</th>
		  </tr>
		 </thead>
		 <tbody>
		{foreach from=$items item=entry}
		  <tr class="{$entry->rowclass}">
		    <td>{$entry->date_event|date_format:"%d/%m"}</td>
		    <td class="name">{$entry->advnompre}({$entry->advclaof})</td>
			<td>{$entry->vd}</td>
			<td>{$entry->pointres}</td>
		  </tr>
		{/foreach}
		 </tbody>
		</table>
