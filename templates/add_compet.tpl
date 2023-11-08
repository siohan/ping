{literal}
<script>
 $(function() {
   $( "#m1_date_debut" ).datepicker({ dateFormat: "yy-mm-dd" });
 });
 </script>
{/literal}
<div class="pageoverflow">
{$formstart}
{$record_id}
{*$indivs*}
<div class="pageoverflow">
    <p class="pagetext">Compétition :</p>
    <p class="pageinput"><input type="text" name="idepreuve" value="{$idepreuve}" {$tooltip}</p>
  </div>
	<div class="pageoverflow">
    <p class="pagetext">Date début:</p>
    <p class="pageinput">{$date_debut}</p>
  </div>
	<div class="pageoverflow">
  <p class="pagetext">Date fin:</p>
  <p class="pageinput">{$date_fin}</p>
</div>
<div class="pageoverflow">
<p class="pagetext">Tour ou N° Journée:</p>
<p class="pageinput">{$numjourn}</p>
</div>
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}{$cancel}</p>
  </div>
{$formend}
</div>
