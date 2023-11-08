<div class="pageoverflow">
{form_start action='change_all_dates'}
<input type="hidden" name="record_id" value="{$record_id}">
<div class="pageoverflow">
  <p class="pagetext">Nouvelle date</p>
  <select name="action_choisie">{html_options options=$actions}</select>
  
</div>
<div class="pageoverflow">
  <p class="pagetext">En nombre de jours</p>
  
  <input type="text" name="nombre" value=""></p>
</div>
<div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput"><input type="submit" name="submit" value="Envoyer"></p>
  </div>
{form_end}
</div>
