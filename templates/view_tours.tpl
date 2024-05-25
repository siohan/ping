<div class="dashboard-box">					
		<nav class="dashboard-inner cf">
			<h3 class="dashboard-icon"><i class="fa fa-user"></i>Nb de tours (ou poules)</h3>
			<!-- Content Column -->
			    <div class="c_full cf">
					
					<div class="grid_12">
								{if $nb >0}
									<p class="green">L'épreuve compte {$nb} tours (ou poules) ! Dernier tour : {$last_tour}</p>
									<p><a href="{cms_action_url action=admin_poules idepreuve=$idepreuve}">Voir ?</a> <a href="{cms_action_url action=retrieve_indivs obj=tours idepreuve=$idepreuve}">Rafraichir ?</a></p>
									
								{else}
									<p class="red"><strong>L'épreuve n'a pas (encore) de tours (ou poules)</strong></p>
									<p>Cela peut indiquer que l'accès est coupé ou que l'épreuve est obsolète</p>
									<p><a href="{cms_action_url action=retrieve_indivs obj=tours idepreuve=$idepreuve}">Rafraichir ?</a></p>
								{/if}
					</div>
				</div>
		</nav>
	</div>
