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

<div class="pageoptions"><p class="pageoptions">{$resultscount} résultat(s) trouvé(s)&nbsp;{$itemsfound}</p></div>
{if $resultscount > 0}

<table border="1" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
  <th>{$id}</th>
  <th>{$equipe}</th>
  <th>{$tour}</th>
  <th>{$score}</th>
  <th>{$adversaires}</th>
  <th class="pageicon">&nbsp;</th>
  <th class="pageicon">&nbsp;</th>
  </tr>
 </thead>
 <tbody>
{foreach from=$resultats item=entry}
  <tr>
    <td>{$entry.id}</td>
    <td>{$entry.equipe}</td>
    <td>{$entry.tour}</td>
    <td>{$entry.score_equipe} à {$entry.score_adv}</td>
	<td>{$entry.adversaires}</td>
    <td>{$entry.editlink}</td>
    <td>{$deletelink}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{else}
<div calss="pageoptions"><p>Pas de résultats disponibles</p></div>
{/if}

<div class="pageoptions"><p class="pageoptions">{$createlink}</p></div>
