<div class="pageoverflow">
{form_start}
<input type="hidden" name="idepreuve" value="{$idepreuve}">
<div class="pageoverflow">
    <p class="pagetext">Nom :</p>
    <p class="pageinput"><input type="text" size="45" name="nom" value="{$nom}" readonly></p>
  </div> 
  <div class="pageoverflow">
    <p class="pagetext">Nom sympa pour vos visiteurs:</p>
    <p class="pageinput"><input type="text" size="45" name="friendlyname" value="{$friendlyname}"></p>
  </div>  
<div class="pageoverflow">
    <p class="pagetext">Saison :</p>
    <p class="pageinput"><input type="text" name="saison" value="{$saison}" readonly></p>
  </div>  
	<div class="pageoverflow">
    <p class="pagetext">coefficient:</p>
    <p class="pageinput"><input type="text" name="coefficient" value="{$coefficient}"></p>
  </div>
	<div class="pageoverflow">
  <p class="pagetext">Compétition individuelles:</p>
  <p class="pageinput"><select name="indivs">{cms_yesno  selected=$indivs}</select></p>
</div>
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput"><input type="submit" name="submit" value="Envoyer"><input type="submit" name="cancel" value="Annuler"></p>
  </div>
{form_end}
</div>
