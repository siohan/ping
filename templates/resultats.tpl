<div class="pageoptions">
	<p style="width: 100%">
		<span style="text-align: left">
			<a href="{cms_action_url action='defaultadmin' active_tab=equipes}">{admin_icon icon="back.gif"}Revenir</a> | 
			<a href="{cms_action_url action='retrieve' retrieve=classement_equipes record_id=$record_id}">{admin_icon icon="import.gif"}Rafraichir le classement</a> | 
			<a href="{cms_action_url action='retrieve' retrieve=retrieve_rencontre record_id=$record_id}">{admin_icon icon="import.gif"} Récupérer tous les résultats</a> |
			<a href="{cms_action_url action='retrieve' retrieve=retrieve_rencontre record_id=$record_id}">{admin_icon icon="import.gif"} Récupérer tous les détails des rencontres</a>
		</span>
	</p>
{if $itemcount2 > 0}
<h3>Classement général {if isset($libequipe)} en {$libequipe}{/if}</h3>

<table border="0" cellspacing="0" cellpadding="0" class="table pagetable">
 <thead>
	<tr>
		<th>Clt</th>
		<th>Logo</th>
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
{foreach from=$items2 item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->clt}</td>
	<td>{if $entry->logo ==''}<a href="{cms_action_url action='upload_image' idclub=$entry->idclub}" title="téléverser un nouveau logo" alt="téléverser un nouveau logo">{admin_icon icon="import.gif"}</a>{else}<a href="{cms_action_url action='upload_image' idclub=$entry->idclub}" title="téléverser un autre logo" alt="téléverser un autre logo"><img src="../modules/Ping/images/logos/{$entry->logo}" width="20" height="20"></a>{/if}</td>
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
{/if}
{if $itemcount>0}
<h3>Les rencontres</h3>
{foreach from=$items item=entry}

	{*$form2start*}
	<h4>{$entry->date|date_format:"%d/%m/%Y"} {$entry->compet}</h4>
	
	
		<table border="0" cellspacing="0" cellpadding="0" class="pagetable table">
			<thead>
				<tr>
					<th>Equipe A</th>
					<th>Equipe B</th>
					<th>Score A</th>
					<th>Score B</th>
					<th>Affichage</th>
					<th colspan="3">Actions</th>
				<!--<th><input type="checkbox" id="selectall" name="selectall"></th>-->
			</thead>
			<tbody>
			{foreach from=$prods_{$entry->valeur} item=donnee}
				{if $donnee->club ==1}
				<tr style="background-color: #bfc9ca">
				{else}
				<tr>
				{/if}
					<td>{$donnee->equa}</td>
					<td>{$donnee->equb}</td>
					<td>{$donnee->scorea}</td>
					<td>{$donnee->scoreb}</td>
					<td>{$donnee->display}</td>
					<td>{if $smarty.now|date_format:"%Y-%m-%d" >= $donnee->date_event }
							{if $donnee->uploaded == "0"}
								<a href="{cms_action_url action=retrieve_details_rencontres2 record_id=$donnee->renc_id eq_id=$donnee->eq_id}">{admin_icon icon="import.gif"}</a>
							{else}<a href="{cms_action_url action=admin_details_rencontre record_id=$donnee->renc_id eq_id=$donnee->eq_id}">{admin_icon icon="view.gif"}
							{/if}
						{/if}
						{*{else}
							<a href="{cms_action_url action=admin_details_rencontre record_id=$donnee->renc_id eq_id=$donnee->eq_id}">{admin_icon icon="view.gif"}
						{/if}</td>*}
					<td><a href="{cms_action_url action='edit_rencontre' renc_id=$donnee->renc_id}">{admin_icon icon="edit.gif"}</a></td>
				<!--	<td><input type="checkbox" name="{$actionid}sel[]" value="{$donnee->ren_id}" class="select"></td>-->
				</tr>
			{/foreach}
		</table>
		<!-- SELECT DROPDOWN -->
<!-- <div class="pageoptions" style="float: right;">
<br/>{$actiondemasse}{$submit_massaction}
  </div>
{$form2end}
-->
{/foreach}
{/if}
{*get_template_vars*}
