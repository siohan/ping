{if $step=="1"}
		{if $reussite ==FALSE}
		<div class="pageoverflow">
			<p class="alert alert-danger">La connexion a échouée.
				<ol>
					<li>Vos identifiants sont erronés.</li>
					<li>Votre numéro de série n'a pas été reconnu.</li>
				</ol>
			<p class="warning">Si vous avez déjà utilisé vos identifiants sur un autre système, vous devez récupérer votre numéro de série unique.{$lien}</p>
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
{elseif $step=="3"}
		<div class="pageoverflow">
			<p class="pagetext success">Récupérer les compétitions de ligue : {$compet_zone}</p>
		</div>
{elseif $step=="4"}
		<div class="pageoverflow">
			<p class="pagetext success">Récupérer les compétitions de département : {$compet_zone}</p>
		</div>
{/if}