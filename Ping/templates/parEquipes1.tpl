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
<div class="pageoverflow">
	{$formstart}
	{$formhidden}
	<div class="pageoverflow">
<table>
	<tr><td>Compétition</td><td>{$compet}</td></tr>
	<tr><td>Adversaires</td><td>{$adversaires}</td></tr>
	<tr><td>Tour</td><td>{$tour}</td></tr>
	<tr><td>Equipe</td><td>{$equipe}</td></tr>
	<tr><td>Locaux (A ou B)</td><td>{$locaux}</td></tr>
	{*}<tr>
		<td>
			<table border='1'>
				<tr>
					<th></th><th>Joueur</th><th>Points</th></tr>
				<tr>
					<td>{$prompt_joueurA}</td><td>{$joueurA}</td><td>{$ptsA}</td>
				</tr>
				<tr>
					<td>{$prompt_joueurB}</td><td>{$joueurB}</td><td>{$ptsB}</td>
				</tr>
				<tr>
					<td>{$prompt_joueurC}</td><td>{$joueurC}</td><td>{$ptsC}</td>
				</tr>
				<tr>
					<td>{$prompt_joueurD}</td><td>{$joueurD}</td><td>{$ptsD}</td>
				</tr>
			</table>
		</td>
		<td><table border='1'>
			<tr>
				<th></th><th>Joueur</th><th>Points</th></tr>
			<tr>
				<td>{$prompt_joueurW}</td><td>{$joueurW}</td><td>{$ptsW}</td>
			</tr>
			<tr>
				<td>{$prompt_joueurX}</td><td>{$joueurX}</td><td>{$ptsX}</td>
			</tr>
			<tr>
				<td>{$prompt_joueurY}</td><td>{$joueurY}</td><td>{$ptsY}</td>
			</tr>
			<tr>
				<td>{$prompt_joueurZ}</td><td>{$joueurZ}</td><td>{$ptsZ}</td>
			</tr>
		</table></td>
	</tr>*}
</table>
</div>

<div class="pageoverflow">
<p>{$submit} {$cancel} {$back}</p>
</div>
{$formend}
</div>