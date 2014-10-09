{*
	{if isset($formstart) }
<fieldset>
  <legend>Filtres</legend>
  {$formstart}
  <div class="pageoverflow">
	<p class="pagetext">Type Compétition:</p>
    <p class="pageinput">{$input_compet} </p>
    <p class="pagetext">{$prompt_tour}:</p>
    <p class="pageinput">{$input_tour} </p>
	<p class="pagetext">{$prompt_equipe}:</p>
    <p class="pageinput">{$input_equipe} </p>
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submitfilter}{$hidden|default:''}</p>
  </div>
  {$formend}
</fieldset>
{/if}
*}
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{$lienj1} - {$lienj2}
{if $itemcount > 0}

<table class="pagetable">
 <thead>
  <tr>	
  <th colspan='4'>Résultats</th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td class="equipe">{$entry->equa}</td>
    <td class="score">{$entry->scorea}</td>
    <td> - </td>
	<td class="score">{$entry->scoreb}</td>
	<td class="equipe">{$entry->equb}</td>
    {*<td>{$entry->details}</td>*}
    {*<td>{$entry->deletelink}</td>*}
  </tr>
{/foreach}
 </tbody>
</table>
{/if}
<div class="pageoptions"><p class="pageoptions">{$createlink}</p></div>
