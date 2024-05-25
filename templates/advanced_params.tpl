<style>
      input:invalid {
        border: 2px dashed red;
      }

      input:valid {
        border: 1px solid #aaa;
      }
    </style>
    <h1>Paramètres avancés</h1>
{*$interval_classement|@var_dump*}
<a href="{cms_action_url action=defaultadmin __activetab=configuration}">{admin_icon icon="back.gif"} Revenir à la configuration principale</a>
{form_start action='advanced_params'}

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

<fieldset>
	<legend>Intervalles de récupération automatique des données</legend>
	<p class="warning">Les intervalles .<br />Des intervalles courts peuvent provoquer des latences.</p>
	<div class="pageoverflow">
		<p class="pagetext">Récupération des nouvelles équipes</p>
		<p class="pageinput"><input type="number" name="nb_equipes" value="{$interval_equipes[1]}" min="1" max="30"><select name="unite_equipes">{html_options options=$liste_unite selected=$interval_equipes[0]}</select></p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Récupération des classements des équipes</p>
		<p class="pageinput"><input type="number" name="nb_classement" value="{$interval_classement[1]}" min="1" max="30"><select name="unite_classement">{html_options options=$liste_unite selected=$interval_classement[0]}</select></p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Récupération des feuilles de rencontre et parties</p>
		<p class="pageinput"><input type="number" name="nb_feuilles_parties" value="{$interval_feuilles_parties[1]}" min="1" max="30"><select name="unite_feuilles_parties">{html_options options=$liste_unite selected=$interval_feuilles_parties[0]}</select></p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Récupération auto des joueurs (depuis le spid){cms_help key='help_affiche_club_uniquement' title='Affichage des résultats des équipes'}</p>
		<p class="pageinput"><input type="number" name="nb_joueurs" value="{$interval_joueurs[1]}" min="1" max="30"><select name="unite_joueurs">{html_options options=$liste_unite selected=$interval_joueurs[0]}</select></p>
	</div>
    <div class="pageoverflow">
		<p class="pagetext">Récupération des parties du spid (depuis le spid)</p>
		<p class="pageinput"><input type="number" name="nb_spid" value="{$interval_spid[1]}"><select name="unite_spid">{html_options options=$liste_unite selected=$interval_spid[0]}</select></p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Récupération des nouvelles compétitions</p>
		<p class="pageinput"><input type="number" name="nb_compets" value="{$interval_compets[1]}" min="1" max="30"><select name="unite_compets">{html_options options=$liste_unite selected=$interval_compets[0]}</select></p>
	</div>
</fieldset>

<h2>Les images</h2>
<fieldset>
	<legend>Réglages des paramètres images</legend>

		<p class="warning">Ce sont les photos de tes licenciés.</p>
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
<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput"><input type="submit" name="submit" value="Envoyer"></p>
	</div>
{form_end}
<!---->
<fieldset><legend>Organismes</legend>
<p class="warning"><a href="{cms_action_url action=retrieve retrieve=organismes}">Récupérer les organismes</a>{cms_help key=help_organismes}</p></fieldset>
<fieldset><legend>Compétitions :</legend><p>Récupérez les compétitions :</p>
<ul> 
	<li><a href="{cms_action_url action='retrieve' retrieve=compets idorga=$fede type=E }">{admin_icon icon="import.gif"}Nationales Equipes</a></li>
	<li><a href="{cms_action_url action='retrieve' retrieve=compets idorga=$fede type=I}">{admin_icon icon="import.gif"}Nationales indivs</a></li>
	<li><a href="{cms_action_url action='retrieve' retrieve=compets idorga=$zone type=E}">{admin_icon icon="import.gif"}Zone Equipes</a></li>
	<li><a href="{cms_action_url action='retrieve' retrieve=compets idorga=$zone type=I}">{admin_icon icon="import.gif"}Zone indivs</a></li>
	<li><a href="{cms_action_url action='retrieve' retrieve=compets idorga=$ligue type=E}">{admin_icon icon="import.gif"}Ligue Equipes</a></li> 
	<li><a href="{cms_action_url action='retrieve' retrieve=compets idorga=$ligue type=I}">{admin_icon icon="import.gif"}Ligue indivs</a></li>
	<li><a href="{cms_action_url action='retrieve' retrieve=compets idorga=$dep type=E}">{admin_icon icon="import.gif"}Dép Equipes</a></li>
	<li><a href="{cms_action_url action='retrieve' retrieve=compets idorga=$dep type=I}">{admin_icon icon="import.gif"}Dép indivs</a></li>
</ul>
</fieldset>

<h2>Nettoyage de printemps ?</h2>
<fieldset><legend>Nettoyage</legend>
<p class="warning"><a href="{cms_action_url action=nettoyage}">Supprime les données devenues obsolètes !</a>{cms_help key=help_nettoyage}</p></fieldset>
<fieldset>
<!--
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
-->
