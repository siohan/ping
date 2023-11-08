
<fieldset>
<legend>Test des scripts</legend>
	
	<div class="pageoverflow">
		<p class="pagetext">Phase en cours:</p>
		<p class="pageinput"><select name="phase_en_cours">{html_options options=$liste_phases selected=$phase_en_cours}</select></p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">Saison en cours :</p>
		<p class="pageinput"><input type="text" name="saison_en_cours" value="{$saison_en_cours}"></p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Changement de phase et/ou de saison</p>
		<p class="red">{admin_icon icon="warning.gif"}<strong>Si et seulement si</strong> tu ne veux pas conserver les pages de tes équipes et les page de résultats d'une saison et/ou phase à l'autre ! <br />Au prélable, tu as changé la saison et/ou la phase et récupéré tes équipes. Les détails des pages ne sont pas modifiés</p>
		<p class="pageinput"><a class="orange" href="{cms_action_url action=page_contenu}">Changer les équipes dans les pages et les résultats</a></p>
	</div>

</fieldset>
<fieldset>
	<legend>Journal</legend>
	<div class="pageoverflow">
		<p class="pagetext"> Suppression des entrées de plus de x jours</p>
		<p class="pageinput"><input type="text" name="nettoyage_journal" value="{$nettoyage_journal}"></p>
	</div></fieldset>
<fieldset>
	<legend>Réglages des paramètres images</legend>

		<p class="warning">Ce sont les photos de vos membres.</p>
		<p class="pagetext">Extensions autorisées</p>
		<input type="text" name="allowed_extensions" value="{$allowed_extensions}"/>
		
		<div class="pageoverflow">
			<p class="pagetext">Poids maximal de l'image (en octets)</p>
			<input type="text" name="max_size" value="{$max_size}"/>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Largeur maximale de l'image (en pixels)</p>
			<input type="text" name="max_width" value="{$max_width}"/>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Hauteur maximale de l'image (en pixels)</p>
			<input type="text" name="max_height" value="{$max_height}"/>
		</div>
</fieldset>
<fieldset>
	<legend>Intervalles de récupération automatique des données</legend>
	<p class="warning">Les intervalles sont en secondes (1 jour = 86400 sec, 1 sem = 604800 et un mois = 18 748 800 sec).<br />Des intervalles courts peuvent provoquer des latences.</p>
	<div class="pageoverflow">
		<p class="pagetext">Récupération des nouvelles équipes</p>
		<p class="pageinput"><input type="text" name="interval_equipes" value="{$interval_equipes}"></p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Récupération des classements des équipes</p>
		<p class="pageinput"><input type="text" name="interval_classement" value="{$interval_classement}"></p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Récupération des feuilles de rencontre et parties</p>
		<p class="pageinput"><input type="text" name="interval_feuille_parties" value="{$interval_classement}"></p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Récupération auto des joueurs (depuis le spid){cms_help key='help_affiche_club_uniquement' title='Affichage des résultats des équipes'}</p>
		<p class="pageinput"><input type="text" name="interval_joueurs" value="{$interval_joueurs}"></p>
	</div>
    <div class="pageoverflow">
		<p class="pagetext">Récupération des parties du spid (depuis le spid)</p>
		<p class="pageinput"><input type="text" name="interval_joueurs" value="{$interval_joueurs}"></p>
	</div>
	</fieldset>
	<fieldset><legend>Brûlage</legend>
	<p class="info">Indiquez quel championnat fera l'objet du brûlage</p>
		<select name="chpt_defaut">{html_options options=$liste_epreuves selected=$chpt_defaut}</select>
	</fieldset>
<fieldset><legend>Visibilité des onglets</legend>
<p class="info">Indiquez les onglets que vous souhaitez cacher, vous pouvez les faire réapparaitre</p>
<p class="pagetext">Visibilité de l'onglet Compte</p>
<select name="compte_tab">{cms_yesno selected=$compte_tab}</select>

<p class="pagetext">Visibilité de l'onglet Epreuves</p>
<select name="epreuv_tab">{cms_yesno selected=$epreuv_tab}</select>

<p class="pagetext">Visibilité de l'onglet Contacts</p>
<select name="contacts_tab">{cms_yesno selected=$contacts_tab}</select>
</fieldset>
<fieldset>	
	<legend>Pages de détails</legend>
	<p class="info">Indiquez les pages dans lesquelles vous souhaitez voir le détail des scores, résultats apparaitrent</p>
	<div class="pageoverflow">
		<p class="pagetext">Alias de la page de la feuille de rencontre {cms_help key='help_details_rencontre_page' title='Alias de la page feuille de rencontre'}</p></p>
		<p class="pageinput"><input type="text" name="details_rencontre_page" value="{$details_rencontre_page}"></p>
		</fieldset>
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput"><input type="submit" name="submit" value="Envoyer"></p>
	</div>
{form_end}

<a class="orange" href="{cms_action_url action='nettoyage'}" role="button">Supprimer les données obsolètes ?</a> {cms_help key='help_nettoyage' title='Suppression des données obsolètes'}
{if $display_mods == true}
<fieldset>
	<legend>Export vers d'autres modules (si installés et activés !)</legend>
<fieldset>
	<legend>Export des joueurs vers le module Adhérents</legend>
	<p>Seuls les nouveaux joueurs sont exportés à chaque fois</p>
	<a href="{cms_action_url action='admin_export_adherents' obj=export_members}">Exporter</a>
	
</fieldset>
<fieldset>
	<legend>Export des épreuves vers le module Compositions</legend>
	{$startformexport2}
	{$exportsubmit2}
	{$endformexport2}
</fieldset>
{/if}
