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
{if $itemcount > 0}
<p class="pageoptions">{$phase1} | {$phase2}</p>
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>{$id}</th>
		<th>{$equipe}</th>
		<th>Niveau</th>
		<th>Compétition</th>
		<th>Nom court</th>
		<th colspan="4">Actions</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->friendlyname}</td>
    <td>{$entry->libequipe}</td>
    <td>{$entry->clt}</td>
    <td>{$entry->equipe}</td>

  </tr>
{/foreach}
 </tbody>
</table>
{else}
<p>No results yet</p>
{/if}

