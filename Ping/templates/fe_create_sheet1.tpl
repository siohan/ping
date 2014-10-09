<label>{$text}</label>
{if $error}
<font color="red">
{/if}
{if $message ne ""}
<strong>{$message}</strong>
{/if}
{if $error}
</font>
{/if}
{literal}
<script>
 $(function() {
   $( "#cntnt01date_compet" ).datepicker({ dateFormat: "yy-mm-dd" });
 });
 </script>
{/literal}
<div class="pageoverflow">
	{$formstart}
	{$formhidden}
	<div class="pageoverflow">
<table>
		<tr><td>Type compétition</td><td>{$input_typeCompetition}</td></tr>
		<tr><td>Date de la compétition</td><td>{$date_compet}</td></tr>
	<tr><td>Adversaires</td><td>{$adversaires}</td></tr>
	<tr><td>Tour</td><td>{$tour}</td></tr>
	<tr><td>Equipe</td><td>{$equipe}</td></tr>
	<tr><td>Locaux (A ou B)</td><td>{$locaux}</td></tr>
</table>
</div>

<div class="pageoverflow">
<p>{$submit} {$cancel} {$back}</p>
</div>
{$formend}
</div>