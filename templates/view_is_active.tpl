<a href="{cms_action_url action='defaultadmin' __activetab=compets indivs_suivies=1}"><= Revenir à la liste</a>
<h1>{$compet} <a href="{cms_action_url action=add_type_compet record_id=$idepreuve}">{admin_icon icon="edit.gif" title="changer le nom de l'épreuve"}</a></h1>
<p class="green"><a href="{cms_action_url action=retrieve_indivs obj=divisions idepreuve=$idepreuve idorga=$idorga}">{admin_icon icon="import.gif"} Tout télécharger</a></p>
<p class="red"><a href="{cms_action_url action=misc_actions obj=raz_epreuve record_id=$idepreuve}">{admin_icon icon="delete.gif"}Tout effacer ?</a></p>
<p class="information">Tag pour affichage {$tag} {cms_help key=help_tag}</p>
<section class="cf">
	<div id="topcontent_wrap">
		<div class="dashboard-box">					
		<nav class="dashboard-inner cf">
			<h3 class="dashboard-icon"><i class="fa fa-user"></i>Actif ?</h3>
			<!-- Content Column -->
			    <div class="c_full cf">
					
					<div class="grid_12">
								{if $actif == "1"}
									<p class="green">L'épreuve est active !</p>
									<p><a href="{cms_action_url action=misc_actions obj=desactive_epreuve record_id=$idepreuve}">Désactiver ?</a></p>
									<p>Désactiver l'épreuve supprimera aussi tous les résultats de cette épreuve.</p>
								{else}
									<p class="red"><strong>L'épreuve n'est pas activée !</strong></p>
									<p>Il est impossible de chercher des résultats si l'épreuve n'est pas activée.</p>
									<p><a href="{cms_action_url action=misc_actions obj=active_epreuve record_id=$id}">Activer ?</a></p>
								{/if}
					</div>
				</div>
		</nav>
	</div>
