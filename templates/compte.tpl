{form_start action='admin_compte_tab'}
<fieldset>
	<legend>Données du compte de ton club(fournies par la FFTT)</legend>
	<div class="pageoverflow">
		<p class="pagetext">Id de ton application</p>
		<p class="pageinput"><input type="text" name="idAppli" value="{$idAppli}"></p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">Mot de passe:</p>
		<p class="pageinput"><input type="password" name="motdepasse" value="{$motdepasse}"></p>
	</div>
</fieldset>
	<div class="pageoverflow">
			<p class="pagetext">&nbsp;</p>
			<p class="pageinput"><input type="submit" name="submit" value="Envoyer"></p>
		</div>
{form_end}
