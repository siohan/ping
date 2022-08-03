<div class="pageoverflow">
{form_start action='change_horaire'}
<input type="hidden" name="sels" value="{$sels}">
<div class="pageoverflow">
  <p class="pagetext">Nouvel horaire</p>
  <p class="pageinput">{html_select_time prefix="hor_" display_seconds=false minute_interval=15}</p>
</div>

<div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput"><input type="submit" name="submit" value="Envoyer"></p>
  </div>
{form_end}
</div>
