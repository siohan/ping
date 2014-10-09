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
    <p class="pagetext">Type Compétition:</p>
    <p class="pageinput">{$epreuve}</p>
  </div>  
<div class="pageoverflow">
    <p class="pagetext">N° Journée :</p>
    <p class="pageinput">{$numjourn}</p>
  </div>
	<div class="pageoverflow">
    <p class="pagetext">Adversaire:</p>
    <p class="pageinput">{$nom} - {$pts_joueur}</p>
  </div>
<div class="pageoverflow">
    <p class="pagetext">Classement adversaire:</p>
    <p class="pageinput">{$classement}</p>
  </div>
<div class="pageoverflow">
    <p class="pagetext">Victoire ou défaite:</p>
    <p class="pageinput">{$victoire}</p>
  </div>

  <div class="pageoverflow">
    <p class="pagetext">Ecart:</p>
    <p class="pageinput">{$ecart}</p>
  </div>
 <div class="pageoverflow">
    <p class="pagetext">Coefficient de l'épreuve:</p>
    <p class="pageinput">{$coeff}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}{$cancel}</p>
  </div>
{$formend}
</div>
