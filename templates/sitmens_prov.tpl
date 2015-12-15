<script src="http://code.jquery.com/jquery.min.js"></script>
{literal}
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() { 
        $('table').tablesorter( { sortList:[[0,0],[1,0]] } ); 
    } 
);
//]]>
</script>
{/literal}
<div class="pageoptions"><p class="pageoptions">{$returnlink}</p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount > 0}
<table class="table table-bordered tablesorter" id="tablesorter">
	<thead>
		<th>Joueur</th>
		<!--<th>Prog mois</th>-->
		<th>Clt référence</th>
		<th>Points en cours</th>
		<th>Bilan</th>
		
	</thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->joueur}</td>
	<td>{$entry->clt}</td>
	<td>{$entry->somme}</td>
	<td>{$entry->bilan}</td>
	<td class="visuallyhidden">{$entry->details}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{else}
<p>Les situations mensuelles sont à jour</p>
{/if}
<div class="pageoptions"><p class="pageoptions">{$createlink}</p></div>
