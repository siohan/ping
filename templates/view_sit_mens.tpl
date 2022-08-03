<div class="dashboard-box">					
	<nav class="dashboard-inner cf">
		<h3 class="dashboard-icon"><i class="fa fa-user"></i>Situation mensuelle</h3>
		<!-- Content Column -->
			<div class="c_full cf">
				<div class="grid_12">
					{if $validation == '1'}
						<p class="green">Mis à jour le  {$details.sit_mens} </p>
						<p><a href="{cms_action_url action=misc_actions obj=refresh_sit_mens record_id=$licence}">Rafraichir</a></p>
					{else}
						<p class="red"><strong>Le joueur n'a pas de compte spid</strong></p>
					{/if}
				</div>
			</div>
	</nav>
</div>
