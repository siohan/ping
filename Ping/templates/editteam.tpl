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
   <p class="pagetext">Saison:</p>
   <p class="pageinput">{$saison}</p>
 </div>
 <div class="pageoverflow">
    <p class="pagetext">Phase:</p>
    <p class="pageinput">{$phase}</p>
  </div> 
<div class="pageoverflow">
    <p class="pagetext">Equipe:</p>
    <p class="pageinput">{$libequipe}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">Division</p>
    <p class="pageinput">{$libdivision}</p>
  </div>
<div class="pageoverflow">
    <p class="pagetext">Donnez un nom court (ex N1 A):</p>
    <p class="pageinput">{$friendlyname}</p>
  </div>
<div class="pageoverflow">
    <p class="pagetext">Id de la division:</p>
    <p class="pageinput">{$iddiv}</p>
  </div>
<div class="pageoverflow">
    <p class="pagetext">Id de la poule:</p>
    <p class="pageinput">{$idpoule}</p>
  </div>
<div class="pageoverflow">
    <p class="pagetext">Organisateur:</p>
    <p class="pageinput">{$organisme}</p>
  </div>
<div class="pageoverflow">
    <p class="pagetext">Compétition:</p>
    <p class="pageinput">{$type_compet}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$Ajouter}{$submit}{$cancel}{$back}</p>
  </div>
{$formend}
</div>
