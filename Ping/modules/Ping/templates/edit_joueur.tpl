{literal}
<script>
 $(function() {
   $( "#m1_birthday" ).datepicker({ dateFormat: "yy-mm-dd" });
 });
 </script>
{/literal}
<div class="pageoverflow">
{$formstart}

<div class="pageoverflow">
    <p class="pagetext">Actif:</p>
    <p class="pageinput">{$actif}{cms_help key='help_explanation' title=$actiftext}</p>
  </div>
 <div class="pageoverflow">
    <p class="pagetext">Nom:</p>
    <p class="pageinput">{$nom}</p>
  </div> 
<div class="pageoverflow">
    <p class="pagetext">Prénom:</p>
    <p class="pageinput">{$prenom}</p>
  </div>
{if $licence !=""}
  <div class="pageoverflow">
    <p class="pagetext">Licence</p>
    <p class="pageinput">{$licence}</p>
  </div> 
{else}
{$licence}
{/if}
<div class="pageoverflow">
   <p class="pagetext">Date Naissance:</p>
   <p class="pageinput">{$birthday}</p>
 </div>  
<div class="pageoverflow">
   <p class="pagetext">Sexe:</p>
   <p class="pageinput">{$sexe}</p>
 </div>
 <div class="pageoverflow">
    <p class="pagetext">adresse:</p>
    <p class="pageinput">{$adresse}</p>
  </div> 
<div class="pageoverflow">
    <p class="pagetext">Ville:</p>
    <p class="pageinput">{$ville}</p>
  </div>
<div class="pageoverflow">
    <p class="pagetext">Code postal:</p>
    <p class="pageinput">{$codepostal}</p>
  </div>
 <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}{$cancel}</p>
  </div>
{$formend}
</div>
