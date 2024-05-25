<?php
##################################################################
#                                                               ##
#        Administration des poules insérées pour le classement  ##
#                         et les parties                        ##
##################################################################

if( !isset($gCms) ) exit;
$db = cmsms()->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
//créations de liens de récupération des compétitions
//on récupère d'abord les préférences de zones, ligues et département
$saison = (isset($params['saison'])?$params['saison']:$this->GetPreference('saison_en_cours'));
$fede = $this->GetPreference('fede');
$zone = $this->GetPreference('zone');
$ligue = $this->GetPreference('ligue');
$dep = $this->GetPreference('dep');
$parms = array();
$nb_params = 0; //on instancie un compteur de paramètres

$idepreuve = '';
$now = time();
$ping_ops = new ping_admin_ops();
$ret = new retrieve_ops;
$epreuves = new EpreuvesIndivs;
$nom_club = $epreuves->nom_club();
if (isset($params['idepreuve']) && $params['idepreuve'] !='')
{
	//on va chercher le nom de l'épreuve pour le mettre en titre
	$ep = new EpreuvesIndivs;
	$det = $ep->details_epreuve($params['idepreuve']);
	$titre = $det['friendlyname'];
	$smarty->assign('titre', $titre);
	$smarty->assign('idepreuve', $params['idepreuve']);
}
$iddivision = '';
$result= array ();
$query = "SELECT pou.id AS tour_id, dv.libelle,dv.idorga,pou.idepreuve,pou.iddivision, pou.tour, pou.tableau , pou.date_prevue, pou.uploaded FROM ".cms_db_prefix()."module_ping_divisions AS dv, ".cms_db_prefix()."module_ping_div_tours AS pou WHERE dv.idepreuve = pou.idepreuve AND dv.iddivision = pou.iddivision AND pou.date_prevue < ?";// AND dv.saison = pou.saison AND pou.saison = ?";//" ORDER BY dv.iddivision,pou.tour ASC";//pou.date_debut, pou.date_fin,pou.uploaded_parties,pou.uploaded_classement FROM ".cms_db_prefix()."module_ping_divisions AS dv, ".cms_db_prefix()."module_ping_div_tours AS pou WHERE dv.idepreuve = pou.idepreuve AND dv.iddivision = pou.iddivision AND dv.saison = pou.saison AND pou.saison = ?";//" ORDER BY dv.iddivision,pou.tour ASC";
$parms['now'] = $now;
	
if (isset($params['idepreuve']) && $params['idepreuve'] !='')
{
	$nb_params++;
	$idepreuve = $params['idepreuve'];
	$query.=" AND pou.idepreuve = ?";
	$parms['idepreuve'] = $idepreuve;
}

/*
if(isset($params['iddivision']) && $params['iddivision'] != '')
{
	$iddivision = $params['iddivision'];
	//$query.=" AND pou.iddivision = ?";
	//$parms['iddivision'] = $iddivision;
	//$nb_params++;
}
 
if(isset($params['idorga']) && $params['idorga'] != '')
{
	$idorga = $params['idorga'];
	$nb_params++;
}
* */
$query.=" ORDER BY pou.date_prevue DESC";	
$query.=" LIMIT ?, 100";
if(isset($params['number']))
{
	$parms['number'] = (int) $params['number'];
}
else
{
	$parms['number'] = 0;
}

	$dbresult= $db->Execute($query, $parms);

	
$smarty->assign('now', time());
$smarty->assign('refresh',
		$this->CreateLink($id, 'refresh',$returnid, $contents="Maj", array("idepreuve"=>$idepreuve)));
$rowclass = '';
//echo $query;
$rowarray= array();

if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$idorga = $row['idorga'];
	
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->tour_id = $row['tour_id'];
	$onerow->idepreuve= $row['idepreuve'];
	$onerow->nom_epr = $epreuves->get_epr_name($row['idepreuve']);
	$onerow->iddivision= $row['iddivision'];
	$onerow->tour= $row['tour'];
	$onerow->tableau = $row['tableau'];
	$onerow->libelle= $row['libelle'];	
	$onerow->tab_in_cla = $epreuves->tableau_in_cla($row['idepreuve'], $row['tableau']);
	$onerow->really_uploaded = 
	$onerow->date_epr = $row['date_prevue'];
	$onerow->date_prevue = $epreuves->first_tour($row['idepreuve'], $row['iddivision']);
	$onerow->players = $epreuves->nb_players_incla($row['idepreuve'], $nom_club);
	$onerow->uploaded = $row['uploaded'];
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
else
{
	$this->Redirect($id, 'retrieve_div_results',$returnid,array("direction"=>"tour","idepreuve"=>$idepreuve, "iddivision"=>$iddivision,"id_orga"=>$idorga));
}

$smarty->assign('itemsfound', $this->Lang('resultsfound'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);

$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Marquer comme téléchargé"=>"uploaded", "supprimer les classements inutiles"=>"del_tableau");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));

echo $this->ProcessTemplate('list_poules.tpl');


#
# EOF
#
?>
