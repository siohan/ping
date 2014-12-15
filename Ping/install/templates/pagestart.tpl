<h2>Merci d&#039;avoir choisi CMS Made Simple&trade;</h2>

<form action="{$smarty.server.PHP_SELF|htmlspecialchars}?sessiontest=1" method="post" name="pagestartform" id="pagestartform">
<table class="settings" border="0">
	<thead class="tbcaption">
	    <tr>
	    	<td style="font-size: 1em; text-align:center;">Choisissez votre langue pour la suite de l&#039;installation<br />Cela affecte uniquement le processus d&#039;installation/mise &agrave; jour, et n&#039;aura aucun effet sur les param&egrave;tres par d&eacute;faut de CMS Made Simple&trade;</td>
	    </tr>
    </thead>
	<tbody>
		<tr>
			<td align="center">
				<select name="default_cms_lang">
	{foreach from=$languages item=lang}
					<option value="{$lang}">{$lang}</option>
	{/foreach}
				</select>
			</td>
		</tr>
	</tbody>
</table>

{if isset($release_notes)}
<table class="settings" border="0">
	<thead class="tbcaption">
		<tr>
			<td class="msg-botton">Cette version contient les notes pour effectuer correctement la mise &agrave; jour n&eacute;cessaire (en anglais - Traduction Fr partielle). <br /><strong> Merci de lire ATTENTIVEMENT avant d&#039;engager le processus ..</strong>.</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td align="center">
				<textarea cols="80" rows="6">{$release_notes}</textarea>
			</td>
		</tr>
	</tbody>
</table>
{/if}

<div class="continue">
	<input type="submit" name="submit" value="Envoyer" />
</div>

</form>
