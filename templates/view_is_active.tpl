<a href="{cms_action_url action='defaultadmin'}"><= Revenir à la liste</a>
<section class="cf">
	<div id="topcontent_wrap">
		<div class="dashboard-box">					
		<nav class="dashboard-inner cf">
			<h3 class="dashboard-icon"><i class="fa fa-user"></i>Actif ?</h3>
			<!-- Content Column -->
			    <div class="c_full cf">
					
					<div class="grid_12">
								{if $actif == true}
									<p class="green">Le membre est actif !</p>
									<p><a href="{cms_action_url action=chercher_adherents_spid obj=desactivate record_id=$genid}">Désactiver ?</a></p>
								{else}
									<p class="red"><strong>Le membre est inactif !</strong></p>
									<p>Quand le membre est inactif, il ne peut appartenir à un groupe, avoir une cotisation, un accès à l'espace privé, etc...</p>
									<p><a href="{cms_action_url action=chercher_adherents_spid obj=activate record_id=$genid}">Activer ?</a></p>
								{/if}
					</div>
				</div>
		</nav>
	</div>
