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
{$edit}
<div class="pageoverflow">
    <p class="pagetext">Type Compétition:</p>
    <p class="pageinput">{$name}</p>
  </div>  
<div class="pageoverflow">
    <p class="pagetext">Code compétition {cms_help key="help_code_compet"}</p>
    <p class="pageinput">{$code_compet}</p>
  </div>
	<div class="pageoverflow">
    <p class="pagetext">Coefficient: {cms_help key="help_coefficient"}</p>
    <p class="pageinput">{$coefficient}</p>
  </div>
<div class="pageoverflow">
    <p class="pagetext">Compétion individuelle ?</p>
    <p class="pageinput">{$indivs}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}{$dupliquer}{$cancel}</p>
  </div>
{$formend}
</div>
