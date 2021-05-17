
{form_start action='admin_options_tab'}

<fieldset>
<legend>Configuration principale</legend>
	
	<div class="pageoverflow">
		<p class="pagetext">Phase en cours:</p>
		<p class="pageinput"><input type="text" name="phase_en_cours" value="{$phase_en_cours}"></p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">Saison en cours :</p>
		<p class="pageinput"><input type="text" name="saison_en_cours" value="{$saison_en_cours}"></p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Affiche les résultats du club uniquement:{cms_help key='help_affiche_club_uniquement' title='Affichage des résultats des équipes'}</p>
		<p class="pageinput"><select name="affiche_club_uniquement">{cms_yesno selected=1}</select></p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">inclus les dates des rencontres ds le module calendrier :</p>
		<p class="pageinput"><select name="populate_calendar">{cms_yesno selected=0}</select></p>
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