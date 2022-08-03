<div class="pageoverflow">
{form_start action='change_date_event'}
<input type="hidden" name="sels" value="{$sels}">
<div class="pageoverflow">
  <p class="pagetext">Nouvelle date</p>
  <p class="pageinput">{html_select_date prefix="start_" start_year='2020' end_year='+20'}@{html_select_time prefix="hor_" display_seconds=false minute_interval=15}</p>
</div>

<div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput"><input type="submit" name="submit" value="Envoyer"></p>
  </div>
{form_end}
</div>
