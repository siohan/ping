{literal}
<script>
 $(function() {
   $( "#m1_date_compet" ).datepicker({ dateFormat: "yy-mm-dd" });
 });
 </script>
{/literal}
<label>{$text}</label>
{if $error}
<font color="red">
{/if}
{if $message ne ""}
<strong>{$message}</strong>
{/if}
{if $error}
</font>
{/if}
<div class="pageoverflow">
{$formstart}
{$record_id}
  
<div class="pageoverflow">
   <p class="pagetext">Clé:</p>
   <p class="pageinput">{$cle}</p>
 </div>
 <div class="pageoverflow">
    <p class="pagetext">Type compétition:</p>
    <p class="pageinput">{$type_compet}</p>
  </div> 
<div class="pageoverflow">
    <p class="pagetext">Date compétition:</p>
    <p class="pageinput">{$date_compet}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_equipe}:</p>
    <p class="pageinput">{$equipe}</p>
  </div>
<div class="pageoverflow">
    <p class="pagetext">{$prompt_adversaires}:</p>
    <p class="pageinput">{$adversaires}</p>
  </div>
<div class="pageoverflow">
    <p class="pagetext">{$prompt_tour}:</p>
    <p class="pageinput">{$tour}</p>
  </div>
<div class="pageoverflow">
    <p class="pagetext">{$prompt_score_equipe}:</p>
    <p class="pageinput">{$score_equipe}</p>
  </div>

  <div class="pageoverflow">
    <p class="pagetext">{$prompt_score_adv}:</p>
    <p class="pageinput">{$score_adv}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}{$cancel}</p>
  </div>
{$formend}
</div>
