
{if $step == "2"}
<p class="green">Nous avons récupéré les informations suivantes : 
	<ul>
		<li>Coordonnées du correspondant</li>
		<li>Coordonnées de la salle</li>
	</ul>
</p>
<p class="information">Cliquez sur "Continuer" pour passer à l'étape suivante. </p> <a href="{cms_action_url action='getInitialisation' step=3}">Continuer</a></p>
{/if}

{if $step == "3"}
<p class="green">Compétitions retrouvées.</p>
<ul>
	<li>{$comp_dep_eq} compétitons départementales par équipes retrouvées</li>
	<li>{$comp_dep_indivs} compétitons départementales individuelles retrouvées</li>
	<li>{$comp_ligue_eq} compétitons régionales par équipes retrouvées</li>
	<li>{$comp_ligue_indivs} compétitons régionales individuelles retrouvées</li>
	<li>{$comp_zone_eq} compétitons de zone par équipes retrouvées</li>
	<li>{$comp_zone_indivs} compétitons de zone individuelles retrouvées</li>
</ul>
<p class="information">Les compétitions nationales sont pré-installées. Une autre compétition manque ? Pas de panique, vous pourrez encore les récupérer plus tard. Pensez à renseigner les coefficients des compétitions pour les calculs du SPID.<br />Cliquez sur "Continuer" pour passer à l'étape suivante. </p> <a href="{cms_action_url action='getInitialisation' step=4}">Continuer</a></p> 
{/if}

{if $step == "4"}<p class="green">Tes équipes.</p>
<ul>
	<li>{$eq_masc} équipes masculines (Championnat de France par équipes masculin)</li>
	<li>{$eq_fem} équipes féminines (Championnat de France par équipes féminin)</li>
	<li>{$eq_undefined} autres équipes</li>
</ul>

<p class="information">Donne un nom court à tes équipes, plus facilement identifiables et surtout donne l'horaire habituel des rencontres à chacune d'entre elles(ex 17h00). </p> <a href="{cms_action_url action='getInitialisation' step=5}">Continue !</a></p> {/if}

{if $step == "5"}<p class="green">Classements de tes équipes et calendriers récupérés</p>
<p><a href="{cms_action_url action='getInitialisation' step=6}">Continue !</a></p>
{/if}

{if $step == "6"}
<p class="green">Joueurs récupérés</p>
	
<p class="information"></p> <a href="{cms_action_url action='getInitialisation' step=7}">Continue !</a></p>{/if}
{if $step == ""}{/if}
{if $step == ""}{/if}
{if $step == ""}{/if}
{if $step == ""}{/if}
{if $step == ""}{/if}
{if $step == ""}{/if}
{if $step == ""}{/if}
{if $step == ""}{/if}

		
		
	
