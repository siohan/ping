<div class="pageoverflow">
{form_start action=edit_team}
<input type="hidden" name="record_id" value="{$record_id}">
<input type="hidden" name="saison" value="{$saison}">
<input type="hidden" name="phase" value="{$phase}">
<input type="hidden" name="liendivision" value="{$liendivision}">
<input type="hidden" name="idpoule" value="{$idpoule}">
<input type="hidden" name="phase" value="{$phase}">
<div class="pageoverflow">
    <p class="pagetext">Libellé officiel</p>
    <p class="pageinput"><input type="text" name="libequipe" value="{$libequipe}"> {*cms_help key='help_friendlyname'*}</p>
</div>
<div class="pageoverflow">
    <p class="pagetext">Division</p>
    <p class="pageinput"><input type="text" name="libdivision" value="{$libdivision}"> {*cms_help key='help_friendlyname'*}</p>
</div>
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
