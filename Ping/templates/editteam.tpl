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
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}{$cancel}{$back}</p>
  </div>
{$formend}
</div>
