{if $itemcount >0}
<div class="sp-widget-align-none">
      <aside id="sportspress-league-table-3" class="widget widget_sportspress widget_league_table widget_sp_league_table">
          <div class="sp-template sp-template-league-table">
	     <h4 class="sp-table-caption">Situation mensuelle en cours</h4><div class="sp-table-wrapper">
	
<table class="sp-league-table sp-data-table sp-sortable-table sp-scrollable-table sp-paginated-table" data-sp-rows="180">
 <thead>
	<tr>
                <th>Joueur</th>
                <th>Clt référence</th>
		<th>Points en Cours</th>
		<th>Bilan</th>
                <th>Détails</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass} header">
    <td>{$entry->joueur}</td>
    <td>{$entry->clt}</td>
	<td>{$entry->somme}</td>
	<td>{$entry->bilan}</td>
	<td>{if $entry->bilan !='0'}{$entry->details}{/if}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}