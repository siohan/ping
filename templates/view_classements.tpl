<div class="dashboard-box">					
		<nav class="dashboard-inner cf">
			<h3 class="dashboard-icon"><i class="fa fa-user"></i>Nb de classements</h3>
			<!-- Content Column -->
			    <div class="c_full cf">
					
					<div class="grid_12">
								{if $nb >0}
									<p class="green">L'épreuve compte {$nb} classements</p>
									<p><a href="{cms_action_url action=admin_div_classement idepreuve=$idepreuve}">Voir ?</a> <a href="{cms_action_url action=misc_actions obj=raz_classements record_id=$idepreuve}">Effacer ?</a> <a href="{cms_action_url action=retrieve_indivs obj=classements idepreuve=$idepreuve}">Rafraichir ?</a> <a href="{cms_action_url action=retrieve_indivs obj=classements idepreuve=$idepreuve}">Rafraichir ?</a></p>
									
								{else}
									<p class="red"><strong>L'épreuve n'a pas (encore) de classements disponibles</strong></p>
									<p>Cela peut indiquer que l'accès est coupé ou que l'épreuve ne s'est pas encore disputée ou est obsolète</p>
									<p><a href="{cms_action_url action=retrieve_indivs obj=classements idepreuve=$idepreuve}">Rafraichir ?</a></p>
								{/if}
					</div>
				</div>
		</nav>
	</div>
