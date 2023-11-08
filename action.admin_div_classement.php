<?php
##################################################################
#                                                               ##
#        Administration des classements                             ##
#                                                               ##
##################################################################

if( !isset($gCms) ) exit;
$db = cmsms()->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');

$nom_equipes = $this->GetPreference('nom_equipes');
/* on fait un formulaire de filtrage des résultats*/
//créations de liens de récupération des compétitions
//on récupère d'abord les préférences de zones, ligues et département
$fede = $this->GetPreference('fede');
$zone = $this->GetPreference('zone');
$ligue = $this->GetPreference('ligue');
$dep = $this->GetPreference('dep');
$epreuves = new EpreuvesIndivs;
$club = $epreuves->nom_club();
$is_club = 0; //par défaut le joueur n'appartient pas au club
$smarty->assign('club', $club);
// On récupère les paramètres transmis
$idepreuve = '';
$iddivision = '';
$tableau = '';
$tour = 0;
$error = 0; //on instancie un compteur d'erreurs
$parms = array();
if(isset($params['essai']) && $params['essai'] !='0')
{
	$essai = $params['essai'];
}
else
{
	$essai = 0;//Par défaut 0, si pas de résultats en bdd, recherche automatique
}
$licence = '';
if(isset($params['licence']) && $params['licence'] != '')
{
	$licence = $params['licence'];
	
}
if(isset($params['idepreuve']) && $params['idepreuve'] != '')
{
	$idepreuve = $params['idepreuve'];
	$smarty->assign('idepreuve', $params['idepreuve']);
	//on va chercher le titre
	$epreuves = new EpreuvesIndivs;
	$det = $epreuves->details_epreuve($idepreuve);
	$smarty->assign('titre', $det['friendlyname']);
	
}
else
{
	$error++;
}
if(isset($params['idorga']) && $params['idorga'] != '')
{
	$smarty->assign('idorga', $params['idorga']);
}



if(isset($params['tour']) && $params['tour'] != '')
{
	$tour = $params['tour'];
	//$parms['tour'] = $params['tour'];
	$smarty->assign('tour', $tour);
}


$saison = $this->GetPreference('saison_en_cours');

//on construit un lie de récupération des résultats

$result= array ();
$query = "SELECT id, idepreuve,iddivision,tableau,tour,rang, nom,clt,club,points, saison FROM ".cms_db_prefix()."module_ping_div_classement WHERE idepreuve = ? ";
$parms['idepreuve'] = $idepreuve;

if(isset($params['iddivision']) && $params['iddivision'] != '')
{
	$iddivision = $params['iddivision'];
	$query.=" AND iddivision = ?";
	$parms['iddivision'] = $params['iddivision'];
	$smarty->assign('iddivision', $iddivision);
}
if(isset($params['tableau']) && $params['tableau'] != '')
{
	$tableau = $params['tableau'];
	$query.=" AND tableau = ?";
	$parms['tableau'] = $params['tableau'];
	$smarty->assign('tableau', $tableau);
}  
if(isset($params['club']) && $params['club'] != '')
{
	$query.= "AND club LIKE ?";
	$nclub="%".$params['club']."%";
	$parms['club'] = $nclub;
	$smarty->assign('club', $params['club']);
	
}



$query.=" ORDER BY tableau ASC, rang ASC";

$dbresult= $db->Execute($query,$parms);
$rowclass = '';

$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
		
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		$onerow->tour_id = $row['id'];
		$onerow->idepreuve= $row['idepreuve'];
		$onerow->iddivision= $row['iddivision'];
		$onerow->tour= $row['tour'];
		$onerow->tableau = $row['tableau'];
		$onerow->rang= $row['rang'];
		$onerow->nom= $row['nom'];
		$onerow->clt = $row['clt'];
		$onerow->club = $row['club'];
		$onerow->is_club = $is_club;//détermine si le joueur appratient bien au club
	
	//$onerow->poule= $this->CreateLink($id, 'retrieve_div_results', $returnid, 'Poule',array("direction"=>"tour","idepreuve"=>$row['idepreuve'], "iddivision"=>$row['iddivision']));
	$onerow->classement= $this->CreateLink($id, 'retrieve_div_results', $returnid, 'Classement',array("direction"=>"classement","idepreuve"=>$row['idepreuve'], "iddivision"=>$row['iddivision'],"tableau"=>$row['tableau'],"tour"=>$row['tour']));
	$onerow->partie= $this->CreateLink($id, 'retrieve_div_results', $returnid, 'Parties',array("direction"=>"partie","idepreuve"=>$row['idepreuve'], "iddivision"=>$row['iddivision'],"tableau"=>$row['tableau'],"tour"=>$row['tour']));
	
	//$onerow->editlink = $this->CreateLink($id, 'edit_type_compet',$returnid,$themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'),array("record_id"=>$row['id']));
	
	if($this->CheckPermission('Ping Delete'))
	{
		$onerow->deletelink = $this->CreateLink($id, 'delete', $returnid,$themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'),array("record_id"=>$row['id'], "type_compet"=>"type_compet"));
	}
	
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
else
{
	//pas de résultats, on va les chercher automatiquement ?
	//on regarde si l'essai est à 0 ou non
	if($essai == '0')
	{
		$this->Redirect($id,'retrieve_div_results',$returnid, array("direction"=>"classement","idepreuve"=>$idepreuve, "iddivision"=>$iddivision,"tableau"=>$tableau,"tour"=>$tour,"idorga"=>$params['idorga'],"licence"=>$licence));
	}
}
$smarty->assign('itemsfound', $this->Lang('resultsfound'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);

$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Supprimer"=>"supp_div_classement");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));

echo $this->ProcessTemplate('list_classement.tpl');


#
# EOF
#
?>
