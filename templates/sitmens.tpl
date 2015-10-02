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
		<th>Rang nat</th>
		<th>Rang reg</th>
		<th>Rang dép</th>
		<th>Progression mens</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass} header">
    <td>{$entry->joueur}</td>
    <td>{$entry->points}</td>
	<td>{$entry->clnat}</td>
	<td>{$entry->rangreg}</td>
	<td>{$entry->rangdep}</td>
	<td>{$entry->progmois}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}
<div class="pageoptions"><p class="pageoptions">{*$createlink*}</p></div>
