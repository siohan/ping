{$startform}
<fieldset>
<legend>Configuration principale</legend>
	<div class="pageoverflow">
		<p class="pagetext">Le numéro de votre club</p>
		<p class="pageinput">{$input_club_number}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Votre zone</p>
		<p class="pageinput">{$input_zone}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Votre ligue</p>
		<p class="pageinput">{$input_ligue}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Votre département</p>
		<p class="pageinput">{$input_dep}</p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">Phase en cours:</p>
		<p class="pageinput">{$input_phase}</p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">Saison en cours :</p>
		<p class="pageinput">{$input_saison_en_cours}</p>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Nom générique de vos équipes :</p>
			<p class="pageinput">{$input_nom_equipes}</p>
			</div>

</fieldset>
<fieldset>
	<legend>Autres options</legend>
	<div class="pageoverflow">
		<p class="pagetext">Le calendrier se remplit avec le résultats des poules (recommandé)</p>
		<p class="pageinput">{$input_populate_calendar}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Afficher les résultats de mes équipes uniquement</p>
		<p class="pageinput">{$input_affiche_club_uniquement}</p>
	</div>
	<!--
	<div class="pageoverflow">
		<p class="pagetext">Récupération si situation mensuelle à jour ?</p>
		<p class="pageinput">{$sitmens_ok_only}</p>
	</div>
	-->
	</fieldset>
	<fieldset>
		<legend>Scripts automatiques</legend>
		<fieldset>
			<legend>Spid</legend>
			<div class="pageoverflow">
				<p class="pagetext">Récupération tous les x jours</p>
				<p class="pageinput">{$input_spid_interval}</p>
			</div>
			<div class="pageoverflow">
				<p class="pagetext">Résultats de x joueurs</p>
				<p class="pageinput">{$input_spid_nombres}</p>
			</div>
		</fieldset>
		<fieldset>
			<legend>FFTT</legend>
			<div class="pageoverflow">
				<p class="pagetext">Récupération tous les x jours</p>
				<p class="pageinput">{$input_fftt_interval}</p>
			</div>
			<div class="pageoverflow">
				<p class="pagetext">Résultats de x joueurs</p>
				<p class="pageinput">{$input_fftt_nombres}</p>
			</div>
		</fieldset>
	</fieldset>
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$submit}</p>
	</div>
{$endform}