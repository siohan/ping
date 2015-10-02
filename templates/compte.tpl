{$startform}
<fieldset>
<legend>Données de votre compte (fournies par la FFTT)</legend>
	<div class="pageoverflow">
		<p class="pagetext">Id de votre application</p>
		<p class="pageinput">{$idAppli}</p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">Mot de passe:</p>
		<p class="pageinput">{$motdepasse}</p>
	</div>
	<div class="pageoverflow">
			<p class="pagetext">&nbsp;</p>
			<p class="pageinput">{$submit}</p>
		</div>

</fieldset>
{$endform}
{if $serial !=""}<p>Votre numéro de série unique est : {$serial}</p>{/if}