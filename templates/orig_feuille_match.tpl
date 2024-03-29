{if $itemcount > 0}
<h3>La feuille de match</h3>
<table border="0" cellspacing="0" cellpadding="0" class="table table-bordered">
 <thead>
	<tr>
		<th>Joueur A</th>
		<th>Clt A</th>
		<th>Joueur B</th>
		<th>Clt B</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td><strong>{$entry->xja}</strong></td>
    <td>{$entry->xca}</td>
    <td><strong>{$entry->xjb}</strong></td>
	<td>{$entry->xcb}</td>   
  </tr>
{/foreach}
 </tbody>
</table>
{/if}
{if $itemcount2 > 0}
<h3>Ordre des parties</h3>
<table class="table table-bordered">
	<tr>
		<th>Equipe A</th>
		<th>Score A</th>
		<th>Score B</th>
		<th>Equipe B</th>
	</tr>
{foreach from=$items2 item=entry}  	
	<tr>
		<td>{$entry->joueurA}</td>
		<td>{$entry->scoreA}</td>
		<td>{$entry->scoreB}</td>
		<td>{$entry->joueurB}</td>
	</tr>
{/foreach}
</table>
<table class="table table-bordered">
       <tr>
                <td>{$equa}</td>
                <td {if $scorea > $scoreb}style="background: green;"{elseif $scorea == $scoreb}style="background: blue;"{else}style="background:red;"{/if}>{$scorea}</td>
                <td {if $scoreb > $scorea}style="background: green;"{elseif $scorea == $scoreb}style="background: blue;"{else}style="background:red;"{/if}>{$scoreb}</td>
                <td>{$equb}</td>
        </tr>
</table>

{/if}
