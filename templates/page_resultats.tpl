<p><a href="{cms_action_url action=defaultadmin __activetab=configuration}">{admin_icon icon="back.gif"} Revenir</a></p>
<p class="red">{admin_icon icon="warning.gif"}<strong>Si et seulement si</strong> tu ne veux pas conserver les pages de résultats d'une saison et/ou phase à l'autre ! <br />Au prélable, tu as changé la saison et/ou la phase et récupéré tes équipes. Les détails des pages ne sont pas modifiés</p>
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>Page</th>
		<th>Saison</th>
		<th>Phase</th>
		<th>Epreuve</th>
		<th>Action(s)</th>
	</tr>
</thead>
<tbody>
{foreach from=$items item=entry}
	<tr>
		<td><a target="_blank" href="{cms_selflink page=$entry->content_id urlonly=1}">{$entry->menu_text}{admin_icon icon="view.gif"}</a>  ({$entry->hierarchy_path} - Id de contenu : {$entry->content_id})</td>
		<td>{$entry->saison}</td>
		<td>{$entry->phase}</td>
		<td>{$entry->content}</td>
		<td>{if $entry->saison != $saison_en_cours || $entry->phase != $phase_en_cours}<a href="{cms_action_url action=chg_page_resultats record_id=$entry->content page_contenu=$entry->content_id}">Mettre à jour</a>{else}{admin_icon icon="true.gif"}{/if}</td>
	</tr>
{/foreach}
</tbody>
