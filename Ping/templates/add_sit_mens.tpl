{*<pre>{$rowarray|var_dump}</pre>*}
<div class="pageoverflow">
<p>Les mois non renseignés ne seront pas pris en compte. Le nom et le prénom sont facultatifs.</p>	
{$formstart}
{*$month*}
{*$mois_courant*}
{if $phase =='1'}
{assign var=cnt value=9}
{else}
{assign var=cnt value=1}
{/if}
<div class="pageoverflow">
    <p class="pagetext">Joueur :</p>
    <p class="pageinput">{$nom} {$prenom}</p>
  </div>
<div class="pageoverflow">
    <p class="pagetext">Licence :</p>
    <p class="pageinput">{$licence}</p>
  </div>
{if $phase==2}
<div class="section-9">
	<p class="pagetext">Mois 9 : </p>
	<p class="pageinput"><input type="text" class="cms_textfield" name="{$actionid}month[9]" id="{$actionid}month[]" value="{if isset($rowarray[9])}{$rowarray[9]}{else}{/if}"></p>
</div>
<div class="section-10">
	<p class="pagetext">Mois 10 : </p>
	<p class="pageinput"><input type="text" class="cms_textfield" name="{$actionid}month[10]" id="{$actionid}month[10]" value="{if isset($rowarray[10])}{$rowarray[10]}{else}{/if}"></p>
</div>
<div class="section-11">
	<p class="pagetext">Mois 11 : </p>
	<p class="pageinput"><input type="text" class="cms_textfield" name="{$actionid}month[11]" id="{$actionid}month[11]" value="{if isset($rowarray[11])}{$rowarray[11]}{else}{/if}"></p>
</div>
<div class="section-12">
	<p class="pagetext">Mois 12 : </p>
	<p class="pageinput"><input type="text" class="cms_textfield" name="{$actionid}month[12]" id="{$actionid}month[12]" value="{if isset($rowarray[12])}{$rowarray[12]}{else}{/if}"></p>
</div>


{/if}
{while $cnt <= $mois_courant}

{*foreach from=$rowarray[$cnt] item=entry*}
    <div class="section-{$cnt}">
        
        <p class="pagetext">Mois {$cnt}:</p>
	    <p class="pageinput"><input type="text" class="cms_textfield" name="{$actionid}month[{$cnt}]" id="{$actionid}month[{$cnt}]" value="{if isset($rowarray[$cnt])}{$rowarray[$cnt]}{else}{/if}"></p>
        
    </div>
    {*/foreach*}
{assign var=cnt value=$cnt+1}
{/while}
	
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}{$cancel}</p>
  </div>
{$formend}
</div>
