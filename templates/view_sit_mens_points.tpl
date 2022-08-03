<div class="dashboard-box">					
	<nav class="dashboard-inner cf">
		<h3 class="dashboard-icon"><i class="fa fa-user"></i>Pts FFTT (validés)</h3>
		<!-- Content Column -->
			<div class="c_full cf">
				<div class="grid_12">
					{if $validation == '1'}
						<p class="green">{$details.pts_fftt} </p>
						<p>Dernière mise à jour : {$details.maj_fftt|date_format:"%d/%m/%Y à %H:%M"}  <a href="{cms_action_url action=misc_actions obj=refresh_fftt record_id=$licence}">Rafraichir</a></p>
					{else}
						<p class="red"><strong>Le joueur n'a pas de compte spid</strong></p>
					{/if}
				</div>
			</div>
	</nav>
</div>
