<div class="pageoverflow">
{form_start action=edit_team}
<input type="hidden" name="record_id" value="{$record_id}">
<div class="pageoverflow">
    <p class="pagetext">Libellé officiel</p>
    <p class="pageinput"><input type="text" name="libequipe" value="{$libequipe}" readonly> {*cms_help key='help_friendlyname'*}</p>
<div class="pageoverflow">
    <p class="pagetext">Donnez un nom court : (Ex : N1 ou N1(A))</p>
    <p class="pageinput"><input type="text" name="friendlyname" value="{$friendlyname}"> {*cms_help key='help_friendlyname'*}</p>
 </div>
<div class="pageoverflow">
    <p class="pagetext">Horaire habituel :</p>
    <p class="pageinput">{html_select_time time=$horaire prefix='hor_' display_seconds=false minute_interval=15}
 </div>
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput"><input type="submit" name="submit" value="Envoyer"><input type="submit" name="cancel" value="Annuler"></p>
  </div>
{form_end}
</div>
