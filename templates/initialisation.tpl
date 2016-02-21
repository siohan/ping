{if $step=="1"}
		{if $reussite ==FALSE}
		<div class="pageoverflow">
			<p class="alert alert-danger">La connexion a échouée.
				<ol>
					<li>Vos identifiants sont erronés.</li>
				</ol>
			<p class="warning">{$lien}</p>
			</p>
		</div>
		{elseif $reussite ==TRUE}
		<div class="pageoverflow">
			<p class="pagetext success">La FFTT a acceptée votre connexion ! Vous pouvez continuer ici : {$lien}</p>
		</div>
		{/if}
{elseif $step=="2"}
		<div class="pageoverflow">
			<p class="pagetext success">Récupérer les compétitions de zone : {$compet_zone}</p>
		</div>
{/if}