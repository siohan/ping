<div class="dashboard-box last">					
		<nav class="dashboard-inner cf">
			<h3 class="dashboard-icon"><i class="fa fa-user"></i>Joueurs du club dans les classements</h3>
			<!-- Content Column -->
			    <div class="c_full cf">
					
					<div class="grid_12">
								{if $nb >0}
									<p class="green">{$nb} joueurs dans les classements</p>
									<p><a href="{cms_action_url action=admin_div_classement idepreuve=$idepreuve idorga=$idorga}">Voir ?</a></p>
									
								{else}
									<p class="red"><strong>Pas (encore ?) de joueurs du club dans les résultats</strong></p>
									<p>Accès coupé ? Epreuve non encore disputée ou obsolète ? Pas de joueurs du club dans les classements ?</p>
									<p><a href="{cms_action_url action=retrieve_indivs obj=classements idepreuve=$idepreuve}">Rafraichir ?</a></p>
								{/if}
					</div>
				</div>
		</nav>
	</div>
