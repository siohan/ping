<div class="pageoptions"><p class="pageoptions">{$itemcount2}&nbsp;{$itemsfound}</p></div>
{if $itemcount2 >0}

		<h3>Le détail des résultats spid de {$nom}</h3>
		<table  class="table table-bordered">
		 <thead>
		  <tr>
			<th>Date</th>
			<th>Epreuve</th>
			<th>Adv</th>
			<th>Vic/Def</th>
			<th>Coeff</th>
			<th>Pts(estimés)</th>
		  </tr>
		 </thead>
		 <tbody>
		{foreach from=$items2 item=entry}
		  <tr class="{$entry->rowclass2}">
		    <td>{$entry->date_event|date_format:"%d/%m/%Y"}</td>
			<td>{$entry->epreuve}</td>
		    <td class="name">{$entry->nom}({$entry->classement})</td>
			<td>{$entry->victoire}</td>
			<td>{$entry->coeff}</td>
			<td>{$entry->pointres}</td>
		  </tr>
		{/foreach}
		 </tbody>
		</table>
	{/if}	

	
<div class="pageoptions"><p class="pageoptions">{$createlink}</p></div>
