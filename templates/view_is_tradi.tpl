<div class="dashboard-box">					
		<nav class="dashboard-inner cf">
			<h3 class="dashboard-icon"><i class="fa fa-user"></i>Epreuve suivie ?</h3>
			<!-- Content Column -->
			    <div class="c_full cf">
					
					<div class="grid_12">
								{if $suivi == "1"}
									<p class="green">L'épreuve est suivie !</p>
									<p><a href="{cms_action_url action=misc_actions obj=suivi_ko record_id=$idepreuve}">Ne plus suivre ?</a><br />Les résultats ne seront plus automatiquement recherchés</p>
									
								{else}
									<p class="orange"><strong>L'épreuve n'est pas suivie...</strong></p>
									<p>Les résultats ne seront pas récupérés</p>
									<p><a href="{cms_action_url action=misc_actions obj=suivi_ok record_id=$idepreuve}">Suivre ?</a></p>
								{/if}
					</div>
				</div>
		</nav>
	</div>
