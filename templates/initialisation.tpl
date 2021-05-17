
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

{if $step == "4"}<p class="green">Vos équipes.</p>
<ul>
	<li>{$eq_masc} équipes masculines (Championnat de France par équipes masculin)</li>
	<li>{$comp_dep_indivs} équipes féminines (Championnat de France par équipes féminin)</li>
	<li>{$comp_ligue_eq} autres équipes</li>
</ul>
<p class="information">Donnez un nom court à vos équipes, plus facilement identifiables et donnez l'horaire habituel des rencontres à chacune d'entre elles. </p> <a href="{cms_action_url action='getInitialisation' step=5}">Continuer</a></p> {/if}

{if $step == "5"}<p class="green">Classements de vos équipes et calendriers récupérés</p>
<p class="information"></p> <a href="{cms_action_url action='getInitialisation' step=6}">Continuer</a></p>
{/if}

{if $step == "6"}
<p class="green">Joueurs récupérés</p>
	{if $sit_mens eq "true"}<p class="green">Situation mensuelle Ok</p>
	{else}<p class="red">Situation mensuelle non récupérée, non disponible avant le 10 de chaque mois{/if}
<p class="information"></p> <a href="{cms_action_url action='getInitialisation' step=7}">Continuer</a></p>{/if}
{if $step == ""}{/if}
{if $step == ""}{/if}
{if $step == ""}{/if}
{if $step == ""}{/if}
{if $step == ""}{/if}
{if $step == ""}{/if}
{if $step == ""}{/if}
{if $step == ""}{/if}

		
		
	
