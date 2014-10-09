{if isset($message)}
  {if $error != ''}
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{/if}
<div class="pageoptions"><p class="pageoptions">{$usercount} famille(s) trouvée(s)</p></div>
{if $usercount > 0}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
  <th>Famille</th>
  <th>Adresse</th>
  <th>Commune</th>
  <th>Tranche</th>
  <!--<th>code postal</th>
  <th>Commune</th>
  <th>Tranche;</th>-->
  </tr>
 </thead>
 <tbody>
{foreach from=$resultats item=entry}
  <tr>
    <td>{$entry.nom_complet}</td>
    <td>{$entry.adresse}</td>
	<td>{$entry.commune}</td>
	<td>{$entry.tranche}</td>
    <!--<td>{$entry->codepostal}</td>
    <td>{$entry->commune}</td>
    <td>{$entry->tranche}</td>-->
  </tr>
{/foreach}
 </tbody>
</table>
{/if}

