<script type="text/javascript">
function ouvre_popup(page) {
 window.open(page,"nom_popup","menubar=no, status=no, scrollbars=no, menubar=no, width=600, height=600");
}
</script>
<div class="dashboard-box">					
	<nav class="dashboard-inner cf">
		<h3 class="dashboard-icon"><i class="fa fa-user"></i>Points Spid (Estimation)</h3>
		<!-- Content Column -->
			<div class="c_full cf">
				<div class="grid_12">
					{if $validation == '1'}
						<p class="green"> {$details.pts_spid}  points</p>
						<p>Dernière mise à jour : {$details.maj_spid|date_format:"%d/%m/%Y à %H:%M"} <a href="{cms_action_url action=misc_actions obj=refresh_spid record_id=$licence}">Rafraichir</a></p>
						<p><a href="javascript:ouvre_popup('{cms_action_url action=admin_details_spid licence=$licence}')">Voir tous les résultats du spid</a></p>
					{else}
						<p class="red"><strong>Le joueur n'a pas de compte spid</strong></p>
					{/if}
				</div>
			</div>
	</nav>
</div>
