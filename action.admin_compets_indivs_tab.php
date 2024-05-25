<?php

if( !isset($gCms) ) exit;

$db = cmsms()->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');

//on récupère d'abord les préférences de zones, ligues et département
$smarty->assign('fede', $this->GetPreference('fede'));
$smarty->assign('zone', $this->GetPreference('zone'));
$smarty->assign('ligue', $this->GetPreference('ligue'));
$smarty->assign('dep', $this->GetPreference('dep'));
//1715592886
//On créé une alerte pour l'admin qd une compet indiv est finie (ou un tour est fini) et qu'il n'y a pas de classement
$alert_cla = 0;
$smarty->assign('now', time());

$saison = $this->GetPreference('saison_en_cours');

$ep_ops = new fftt_organismes;
$epreuves = new EpreuvesIndivs;
$eq_p = new equipes_ping;
$club = $epreuves->nom_club();

//on crée une pagination
$nb_epr = (int)$epreuves->nb_epr_actives();

//on fait une pagination de 50 résultats
$nb_pages = ceil($nb_epr/50);
$smarty->assign('nb_pages', $nb_pages);


//on construit LIMIT 
$page_number = 0;
if(isset($params['page_number']) && $params['page_number'] >0)
{
	$page_number = (int) $params['page_number'];
}

$suivant = $page_number+1;
$precedent = $page_number-1;
$smarty->assign('suivant', $suivant);
$smarty->assign('precedent', $precedent);
$smarty->assign('last', $nb_pages);
$smarty->assign('club', $club);
$nclub="%".$club."%";
$smarty->assign('zone_indivs', $this->CreateLink($id, 'retrieve_compets',$returnid,'Récupérer les compétitions individuelles', array("type"=>"I")));
$smarty->assign('titreTableau', 'Liste des compétitions par équipes');
$smarty->assign('suivi', false);
$result= array ();
$active = 1;
$indivs = false;
$parms = array();
$number = $page_number*50;
$query = "SELECT * FROM ".cms_db_prefix()."module_ping_type_competitions";

if(isset($_POST['recherche']) && $_POST['recherche'] !='')
{
	$recherche = "%".$_POST['recherche']."%";
	$query.=" WHERE name LIKE ?";
	$parms['recherche'] = $recherche;
}
else
{

	if(isset($params['indivs_suivies']))
	{
		
		$query.=" WHERE typepreuve IN ('C','I')";
		$smarty->assign('titreTableau', 'Liste des compétitions individuelles');
		$smarty->assign('suivi', true);	
		$indivs = 'true';
	}
	elseif($params['active'] == '2')
	{
		$smarty->assign('titreTableau', 'Liste des compétitions désactivées');
	}
	else
	{
		$query.=" WHERE typepreuve NOT IN ('C', 'I')";
	}
	
	if(isset($params['active']) && $params['active'] != '')
	{
		if($params['active'] == '2')
		{
			$active = 0;
		}
		$query.= " AND actif = ? ";
		$parms['actif'] = $params['active'];
	}
	else
	{
		
		$query.= " AND actif = ? ";
		$parms['actif'] = $active;
	}
}
$smarty->assign('indivs', $indivs);
$query.=" ORDER BY idepreuve DESC, name ASC";
$query.=" LIMIT ?, 50";
$parms['number'] = $number;
//echo $query;
$dbresult = $db->Execute($query, $parms);
//$dbresult= $db->Execute($query, array($active, $number));
$ping_ops = new ping_admin_ops;

//echo $query;
$rowarray= array();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		$onerow->id= $row['id'];
		$onerow->name= $row['name'];
		$onerow->friendlyname= $row['friendlyname'];
		$onerow->tag= $row['tag'];
		$onerow->coefficient= $row['coefficient'];
		$onerow->indivs= $row['indivs'];
		$onerow->idepreuve = $row['idepreuve'];
		$onerow->actif = $row['actif'];
		$onerow->typepreuve = $row['typepreuve'];
		$onerow->divisions = (int)$epreuves->nb_divisions($row['idepreuve']);
		$onerow->tours = (int)$epreuves->nb_tours($row['idepreuve']);
		$onerow->nb_cla = (int)$epreuves->nb_classements($row['idepreuve']);
		$onerow->suivi = $row['suivi'];
		$onerow->saison = $row['saison'];
		$onerow->date_epr = $epreuves->date_epr($row['idepreuve']);
		$onerow->date_prevue= $epreuves->last_tour($row['idepreuve'] );
		$onerow->nb_players = (int) $epreuves->nb_players_incla($row['idepreuve'], $nclub);
		$onerow->orga = $ep_ops->organisateur($row['idorga']);
		$onerow->idorga = $row['idorga'];
		$onerow->has_teams = $eq_p->has_teams($row['idepreuve'],$row['saison']);
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
      }
  }

$smarty->assign('itemsfound', $this->Lang('resultsfound'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('form2start',
			$this->CreateFormStart($id,'mass_action',$returnid));
	$smarty->assign('form2end',
			$this->CreateFormEnd());
	$articles = array("Activer"=>"activate_epr", "Désactiver"=>"desactivate_epr","Suivre"=>"suivi_ok", "Ne plus suivre"=>"suivi_ko", "Supprimer"=>"delete_epr");
	$smarty->assign('actiondemasse',
			$this->CreateInputDropdown($id,'actiondemasse',$articles));
	$smarty->assign('submit_massaction',
			$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));

echo $this->ProcessTemplate('list_compet_indivs.tpl');


#
# EOF
#
?>
