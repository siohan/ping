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
    <p class="pagetext">Equipe: (Ex : RP FOUESNANT1)</p>
    <p class="pageinput">{$libequipe} {*$help_libelle_equipe*}{*cms_help key='help_libelle_equipe'*}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">Division (Ex : Nationale 1 Messieurs Poule C)</p>
    <p class="pageinput">{$libdivision} {*cms_help key='help_libdivision'*}</p>
  </div>
<div class="pageoverflow">
    <p class="pagetext">Donnez un nom court : (Ex : N1 ou N1(A))</p>
    <p class="pageinput">{$friendlyname} {*cms_help key='help_friendlyname'*}</p>
  </div>
<div class="pageoverflow">
    <p class="pagetext">Id de la division : (Voir aide du module)</p>
    <p class="pageinput">{$iddiv} {*cms_help key='help_iddiv'*}</p>
  </div>
<div class="pageoverflow">
    <p class="pagetext">Id de la poule :</p>
    <p class="pageinput">{$idpoule} {*cms_help key='help_idpoule'*}</p>
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
