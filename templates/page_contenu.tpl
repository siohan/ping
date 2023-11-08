<p><a href="{cms_action_url action=defaultadmin __activetab=configuration}">{admin_icon icon="back.gif"} Revenir</a> | <a href="{cms_action_url action=page_resultats}"> Changer aussi les pages de résultats</a></p>
<p class="red">{admin_icon icon="warning.gif"} <strong>Si et seulement si</strong>  tu ne veux pas conserver les pages de tes équipes d'une saison et/ou phase à l'autre !</p>
<p class="yellow">Au prélable, tu as changé la saison et/ou la phase et récupéré tes équipes. Les détails des pages ne sont pas tous modifiés</p>
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>Equipe</th>
		<th>Saison</th>
		<th>Phase</th>
		<th>Action(s)</th>
	</tr>
</thead>
<tbody>
{foreach from=$items item=entry}
	<tr>
		<td><a target="_blank" href="{cms_selflink page=$entry->page_contenu urlonly=1}">{$entry->equipe}({$entry->libdivision} id de contenu : {$entry->page_contenu}){admin_icon icon="view.gif"}</a></td>
		<td>{$entry->saison}</td>
		<td>{$entry->phase}</td>
		<td>{if $entry->saison != $saison_en_cours || $entry->phase != $phase_en_cours}<a href="{cms_action_url action=chgt_contenu record_id=$entry->id page_contenu=$entry->page_contenu}">Mettre à jour</a>{else}{admin_icon icon="true.gif"}{/if}</td>
	</tr>
{/foreach}
</tbody>

