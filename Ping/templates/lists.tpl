{if isset($message)}
  {if $error != ''}
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{/if}
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>
{if $itemcount > 0}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
  <th>{$idtext}</th>
  <th>{$shortdescriptiontext}</th>
  <th>{$activetext}</th>
  <th class="pageicon">&nbsp;</th>
  <th class="pageicon">&nbsp;</th>
  </tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
    <td>{$entry->id}</td>
    <td>{$entry->description}</td>
    <td>{$entry->active}</td>
    <td>{$entry->editlink}</td>
    <td>{$entry->deletelink}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}
<div class="pageoptions"><p class="pageoptions">{$createlink}</p></div>
