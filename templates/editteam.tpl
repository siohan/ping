<div class="pageoverflow">
{$formstart}
{$record_id}
<div class="pageoverflow">
    <p class="pagetext">Equipe: </p>
    <p class="pageinput">{$libequipe} {$help_libelle_equipe}{*cms_help key='help_libelle_equipe'*}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">Division</p>
    <p class="pageinput">{$libdivision} {*cms_help key='help_libdivision'*}</p>
  </div>
<div class="pageoverflow">
    <p class="pagetext">Donnez un nom court : (Ex : N1 ou N1(A))</p>
    <p class="pageinput">{$friendlyname} {*cms_help key='help_friendlyname'*}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}{$cancel}{$back}</p>
  </div>
{$formend}
</div>
