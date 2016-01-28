{*<pre>{$items|var_dump}</pre>*}
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
  $('#selectall').click(function(){
    var v = $(this).attr('checked');
    if( v == 'checked' ) {
      $('.select').attr('checked','checked');
    } else {
      $('.select').removeAttr('checked');
    }
  });
  $('.select').click(function(){
    $('#selectall').removeAttr('checked');
  });
  $('#toggle_filter').click(function(){
    $('#filter_form').toggle();
  });
  {if isset($tablesorter)}
  $('#articlelist').tablesorter({ sortList:{$tablesorter} });
  {/if}
});
//]]>
</script>
<div class="pageoptions"><p style="width: 100%"><span style="text-align: left">{$returnlink}</span>{*<span style="float:right"> - {$all_results}</span>*}</p></div>
{if $itemcount3>0}
<table>
	<tbody>
		<tr>
			{foreach from=$items3 item=entry}
				<td>{$entry->lien_nav} - </td>
			{/foreach}
		</tr>
	</tbody>
</table>
{/if}
{assign var=compteur value = 0}

<p style="width: 100%"><span style="text-align: left"></span><span style="float:right">{$refresh_class} - {$all_results}</span></p>
{if $itemcount2 > 0}
<h3>Classement général {if isset($libequipe)} en {$libequipe}{/if}</h3>

<table border="0" cellspacing="0" cellpadding="0" class="table pagetable">
 <thead>
	<tr>
		<th>Clt</th>
		<th>Equipe</th>
		<th>Joue</th>
		<th>Pts</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items2 item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->clt}</td>
    <td>{$entry->equipe}</td>
    <td>{$entry->joue}</td>
	<td>{$entry->pts}</td>
    
  </tr>
{/foreach}
 </tbody>
</table>
{else}
<p class="warning">{$refresh_class}</p>
{/if}
{if $itemcount>0}
<h3>Les rencontres</h3>
{foreach from=$items item=entry}
{*<p><pre>{$prods_{$compteur++}|var_dump}</pre></p>*}

	
	
	{$form2start}
	<h4>{$entry->date|date_format:"%d/%m/%Y"} {$entry->compet}</h4>
	
	
		<table border="0" cellspacing="0" cellpadding="0" class="pagetable table">
			<thead>
				<tr><th>Equipe A</th>
				<th>Equipe B</th>
				<th>Score A</th>
				<th>Score B</th>
				<th>Affichage</th>
				<th colspan="3">Actions</th>
				<th><input type="checkbox" id="selectall" name="selectall"></th>
			</thead>
			<tbody>
			{foreach from=$prods_{$entry->valeur} item=donnee}
				{if $donnee->club ==1}
				<tr style="background-color: #66FF66">
				{else}
				<tr>
				{/if}
					<td>{$donnee->equa}</td>
					<td>{$donnee->equb}</td>
					<td>{$donnee->scorea}</td>
					<td>{$donnee->scoreb}</td>
					<td>{$donnee->display}</td>
					<td>{$donnee->retrieve_poule_rencontres}</td>
					<td>{$donnee->retrieve_details}{$donnee->viewdetails}</td>
					<td>{$donnee->deletelink}</td>
					<td><input type="checkbox" name="{$actionid}sel[]" value="{$donnee->ren_id}" class="select"></td>
				</tr>
			{/foreach}
		</table>
		<!-- SELECT DROPDOWN -->
<div class="pageoptions" style="float: right;">
<br/>{$actiondemasse}{$submit_massaction}
  </div>
{$form2end}

{/foreach}
{else}
<p class="warning">Récupérer les rencontres de cette poule ? {$all_results} </p>
	{/if}
