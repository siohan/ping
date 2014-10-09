{$startform}
<fieldset>
<legend>Configuration principale</legend>
	<div class="pageoverflow">
		<p class="pagetext">Le numéro de votre club</p>
		<p class="pageinput">{$input_club_number}</p>
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
			
		<!--
    
	<div class="pageoverflow">
		<p class="pagetext">{$title_allow_summary_wysiwyg}:</p>
		<p class="pageinput">{$input_allow_summary_wysiwyg}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_expiry_interval}:</p>
		<p class="pageinput">{$input_expiry_interval}</p>
	</div>
</fieldset>
<br/>
<fieldset>
<legend>{$title_notification_settings}</legend>
	<div class="pageoverflow">
		<p class="pagetext">{$title_formsubmit_emailaddress}:</p>
		<p class="pageinput">{$input_formsubmit_emailaddress}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_email_subject}:</p>
		<p class="pageinput">{$input_email_subject}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_email_template}:</p>
		<p class="pageinput">{$input_email_template}</p>
	</div>
</fieldset>
<br/>

<fieldset>
<legend>{$title_fesubmit_settings}</legend>
	<div class="pageoverflow">
		<p class="pagetext">{$title_fesubmit_status}:</p>
		<p class="pageinput">{$input_fesubmit_status}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_fesubmit_redirect}:</p>
		<p class="pageinput">{$input_fesubmit_redirect}</p>
	</div>
</fieldset>
<br/>

<fieldset>
<legend>{$title_detail_settings}</legend>
	<div class="pageoverflow">
		<p class="pagetext">{$title_detail_returnid}:</p>
		<p class="pageinput">{$input_detail_returnid}<br/>{$info_detail_returnid}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$title_expired_searchable}:</p>
		<p class="pageinput">{$input_expired_searchable}</p>
	</div>
-->
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
	</fieldset>
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$submit}</p>
	</div>
{$endform}
