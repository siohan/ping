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
<div class="pageoverflow">
    <p class="pagetext">Nom :</p>
    <p class="pageinput">{$name}</p>
  </div>  
<div class="pageoverflow">
    <p class="pagetext">Code :</p>
    <p class="pageinput">{$code_compet} {$tooltip}</p>
  </div>
	<div class="pageoverflow">
    <p class="pagetext">coefficient:</p>
    <p class="pageinput">{$coefficient}</p>
  </div>
	<div class="pageoverflow">
  <p class="pagetext">Compétition individuelles:</p>
  <p class="pageinput">{$indivs}</p>
</div>
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}{$cancel}</p>
  </div>
{$formend}
</div>
