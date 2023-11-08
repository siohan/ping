{form_start action='admin_options_tab'}

<fieldset>
<legend>Configuration principale</legend>
	
	<div class="pageoverflow">
		<p class="pagetext">Numéro du club:</p>
		<p class="pageinput"><input type="text" name="club_number" value="{$club_number}"></p></p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Fédération</p>
		<p class="pageinput"><select name="fede">{html_options options=$liste_fede selected=$fede}</select></p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Zone</p>
		<p class="pageinput"><select name="zone">{html_options options=$liste_zones selected=$zone}</select></p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Ligue</p>
		<p class="pageinput"><select name="ligue">{html_options options=$liste_ligues selected=$ligue}</select></p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Département</p>
		<p class="pageinput"><select name="dep">{html_options options=$liste_deps selected=$dep}</select></p>
	</div>
</fieldset>
<fieldset><legend>Phase et saison</legend>
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
		<p>{admin_icon icom="info.gif"} Le journal peut vite devenir lourd de données, il est bon de le rafraichir régulièrement.</p>
	</div>
</fieldset>

<fieldset>	
	<legend>Pages de détails</legend>
	<p class="info">Indique la page dans laquelle tu souhaites voir le détail des scores, résultats par équipes apparaitrent</p>
	<div class="pageoverflow">
		<p class="pagetext">Alias de la page de la feuille de rencontre {cms_help key='help_details_rencontre_page' title='Alias de la page feuille de rencontre'}</p></p>
		<p class="pageinput"><input type="text" name="details_rencontre_page" value="{$details_rencontre_page}"></p>
		<p class="info">Indique la page dans laquelle tu souhaites voir le détail des résultats individuels apparaitrent</p>
	<div class="pageoverflow">
		<p class="pagetext">Alias de la page  </p></p>
		<p class="pageinput"><input type="text" name="details_indivs" value="{$details_indivs}"></p>
		</fieldset>
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput"><input type="submit" name="submit" value="Envoyer"></p>
	</div>
{form_end}


<p><br /><br /><br /><a href="{cms_action_url action=advanced_params}">Voir les paramètres avancés</a></p>
