{*<pre>{$rowarray|var_dump}</pre>*}
<div class="pageoverflow">
	<p>Seules les situations renseignées seront prises en compte (>0)</p>
{$formstart}
{$mois_courant}
<div class="pageoverflow">
    <p class="pagetext">Mois :</p>
    <p class="pageinput">{$choix_mois} </p>
  </div>


{foreach from=$rowarray key=key item=entry}
    <div class="section-{$cnt}">
        
        <p class="pagetext"> {$entry} :</p>
	    <p class="pageinput"><input type="text" class="cms_textfield" name="{$actionid}licence[{$key}]" id="{$actionid}{$key}" value=""></p>
        
    </div>
    {/foreach}

	
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}{$cancel}</p>
  </div>
{$formend}
</div>
