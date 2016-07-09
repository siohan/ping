{*<pre>{$items|var_dump}</pre>*}
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

<div class="pageoptions"><p class="pageoptions">{$mois_precedent}&nbsp;{$mois_suivant} </p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound} </p></div>
{if $itemcount > 0}
<h3> Situation officielle du mois de {$mois_choisi}</h3>
<table class="tablesorter table table-bordered" id="tablesorter">
 <thead>
	<tr class="header">
		<th>Joueur</th>
		<th>Points</th>
		<th>Rang National</th>
		<th>Rang nat (Hors étranger)</th>
		<th>Rang reg</th>
		<th>Rang dép</th>
		<th>Prog mois</th>
		<th>Prog an</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass} header">
    <td>{$entry->joueur}</td>
    <td>{$entry->points}</td>
	<td>{$entry->clglob}</td>
	<td>{$entry->clnat}</td>
	<td>{$entry->rangreg}</td>
	<td>{$entry->rangdep}</td>
	<td>{$entry->progmois}</td>
	<td>{$entry->progann}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}
<div class="pageoptions"><p class="pageoptions">{*$createlink*}</p></div>
