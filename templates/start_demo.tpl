<div class="pageoverflow">
{form_start action='start_demo'}
<div class="pageoverflow">
  <p class="pagetext">Numéro FFTT de votre club</p>
  <p class="pageinput"><input type="text" name="club_number" value="{$club_number}"></p>
</div>
<div class="pageoverflow">
  <p class="pagetext">Votre zone</p>
  <p class="pageinput"><select name="zone">{html_options options=$liste_zones selected=$zone}</select></p>
</div>
<div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput"><input type="submit" name="submit" value="Envoyer"></p>
  </div>
{form_end}
</div>
