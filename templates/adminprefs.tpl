<div class="alert  alert-info">
    <p class="alert-info">La Zone n'apparait pas ? {$recup_orga}</p>
</div>
{$startform}
{$stall}
<fieldset>
<legend>Configuration principale</legend>
	<div class="pageoverflow">
		<p class="pagetext">Votre zone</p>
		<p class="pageinput">{$input_zone}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Phase en cours:</p>
		<p class="pageinput">{$input_phase}</p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">Saison en cours :</p>
		<p class="pageinput">{$input_saison_en_cours}</p>
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
	
	<div class="pageoverflow">
		<p class="pagetext">Récupération du Spid le x jour du mois</p>
		<p class="pageinput">{$jour_sit_mens}</p>
	</div>

	</fieldset>
	
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$submit}</p>
	</div>
{$endform}