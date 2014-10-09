<!--
{if isset($formstart) }
<fieldset>
  <legend>Filtres</legend>
  {$formstart}
  <div class="pageoverflow">
	<p class="pagetext">Id:</p>
    <p class="pageinput">Nom </p>
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
-->
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount > 0}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
  <th>{$id}</th>
  <th>Nom</th>
  <th>Code</th>
  <th>Coefficient</th>
  <th>Nb joueurs</th>
  <th>Nb parties</th>
  <th class="pageicon">&nbsp;</th>
  <th class="pageicon">&nbsp;</th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->id}</td>
    <td>{$entry->name}</td>
    <td>{$entry->code_compet}</td>
    <td>{$entry->coefficient}</td>
    <td>{$entry->joueurs}</td>
	<td>{$entry->parties}</td>
    <td>{$entry->editlink}</td>
    <td>{$entry->deletelink}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}
<div class="pageoptions"><p class="pageoptions">{$createlink}</p></div>
