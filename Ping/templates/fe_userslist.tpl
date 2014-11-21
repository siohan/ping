<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
<h3>Résumé des résultats</h3>
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
<h3>Le détail des résulats spid de : {$joueur}</h3>
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>
	<th>Date</th>
	<th>Epreuve</th>
	<th>Adv</th>
	<th>Vic/Def</th>
	<th>Coeff</th>
	<th>Pts</th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->date_event|date_format:"%d/%m"}</td>
	<td>{$entry->epreuve}</td>
    <td>{$entry->nom}({$entry->classement})</td>
	<td>{$entry->victoire}</td>
	<td>{$entry->coeff}</td>
	<td>{$entry->pointres}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{*/if*}
<div class="pageoptions"><p class="pageoptions">{$createlink}</p></div>
