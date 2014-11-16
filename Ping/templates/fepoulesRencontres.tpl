{*<pre>{$items|var_dump}</pre>*}
<table class="table">
 <thead>
	<tr>	
		<th>Date</th>
		<th>Equipe A</th>
		<th>Score A</th>
		<th>Score B</th>
		<th>Equipe B</th>
  </tr>
 </thead>
 <tbody>
	{foreach from=$items item=entry}
<tr>
	<td>{$entry->date_event|date_format:"%d/%m/%Y"}</td>
	<td>{$entry->equa}</td>
	<td>{$entry->scorea}</td>
	<td>{$entry->scoreb}</td>
	<td>{$entry->equb}</td>
	<td>{$entry->details}</td>
</tr>
	{/foreach}

 </tbody>
</table>