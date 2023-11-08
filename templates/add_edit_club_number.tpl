<div class="pageoverflow">
{form_start action='add_edit_club_number'}
<div class="pageoverflow">
  <p class="pagetext">Numéro FFTT de ton club</p>
  <p class="pageinput"><input type="text" name="club_number" value="{$club_number}"></p>
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
	<div class="pageoverflow">
  <p class="pagetext">Phase en cours</p>
  <p class="pageinput"><input type="text" name="phase_en_cours" value="{$phase_en_cours}"></p>
</div>
<div class="pageoverflow">
  <p class="pagetext">Saison en cours</p>
  <p class="pageinput"><input type="text" name="saison_en_cours" value="{$saison_en_cours}"></p>
</div>
<div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput"><input type="submit" name="submit" value="Envoyer"></p>
  </div>
{form_end}
</div>
