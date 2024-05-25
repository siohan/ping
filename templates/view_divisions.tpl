<div class="dashboard-box last">					
		<nav class="dashboard-inner cf">
			<h3 class="dashboard-icon"><i class="fa fa-user"></i>Nb de divisions</h3>
			<!-- Content Column -->
			    <div class="c_full cf">
					
					<div class="grid_12">
								{if $nb >0}
									<p class="green">L'épreuve compte {$nb} divisions !</p>
									<p><a href="{cms_action_url action=admin_divisions_tab idepreuve=$idepreuve}">Voir ?</a> <a href="{cms_action_url action=misc_actions obj=raz_divisions record_id=$idepreuve}">Effacer ?</a> <p><a href="{cms_action_url action=retrieve retrieve=divisions idepreuve=$idepreuve}">Rafraichir ?</a></p></p>
									
								{else}
									<p class="red"><strong>L'épreuve n'a pas (encore) de divisions</strong></p>
									<p>Cela peut indiquer que l'accès est coupé ou que l'épreuve est obsolète</p>
									<p><a href="{cms_action_url action=retrieve retrieve=divisions idepreuve=$idepreuve idorga=$idorga}">Rafraichir ?</a></p>
								{/if}
					</div>
				</div>
		</nav>
	</div>
