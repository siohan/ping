<pre>{*$items|var_dump*}</pre>
<div class="pageoverflow">
{$formstart}
{$mois_courant}
<div class="pageoverflow">
    <p class="pagetext">Joueur :</p>
    <p class="pageinput">{$nom} {$prenom}</p>
  </div>
<div class="pageoverflow">
    <p class="pagetext">Licence :</p>
    <p class="pageinput">{$licence}</p>
  </div>
{assign var=cnt value=9}
{while $cnt <= $mois_courant}

{*foreach from=$rowarray[$cnt] item=entry*}
    <div class="section-{$cnt}">
        
        <p class="pagetext">Mois {$cnt}:</p>
	    <p class="pageinput"><input type="text" class="cms_textfield" name="m1_month[{$cnt}]" id="m1_month[{$cnt}]" value="{if isset($rowarray[$cnt])}{$rowarray[$cnt]}{else}{/if}"></p>
        
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
