<div class="dashboard-box">					
		<nav class="dashboard-inner cf">
			<h3 class="dashboard-icon"><i class="fa fa-user"></i>Compte Spid</h3>
			<!-- Content Column -->
			    <div class="c_full cf">
					
					<div class="grid_12">
								{if $validation == '1'}
									<p class="green">Le joueur a un compte Spid</p>									
								{else}
									<p class="red"><strong>Le joueur n'a pas de compte spid</strong><a href="{cms_action_url action=misc_actions obj=spid_account}">Créer ?</a></p>
								{/if}
					</div>
				</div>
		</nav>
	</div>
