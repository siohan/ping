<?php
#############################################################
##                 DIVISIONS                               ##
##   Affichage des divisions des épreuves  individuelles   ##
##                                                         ##
#############################################################
if( !isset($gCms) ) exit;
$db = cmsms()->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
require_once(dirname(__file__).'/include/prefs.php');
$saison = $this->GetPreference('saison_en_cours');
$ret = new retrieve_ops;
$smarty->assign('retourlien',
		$this->CreateLink($id,'defaultadmin',$returnid,$contents="<= Retour",array("active_tab"=>"indivs")));
//on fait maintenant la requete principale...
$result= array ();
$query = "SELECT dv.id,tc.name,tc.indivs, tc.idorga, tc.idepreuve, dv.libelle, dv.iddivision,dv.scope, dv.uploaded FROM ".cms_db_prefix()."module_ping_type_competitions AS tc , ".cms_db_prefix()."module_ping_divisions AS dv WHERE  tc.idepreuve = dv.idepreuve AND dv.saison = ? AND tc.indivs = '1' ";
$parms['saison'] = $saison;

if(isset($params['idepreuve']) && $params['idepreuve'] !='')
{
	$smarty->assign('idepreuve', $params['idepreuve']);
	$query.=" AND tc.idepreuve = ?";
	$parms['idepreuve'] = $params['idepreuve'];
}

if(isset($params['idorga']))
{
	$query.=" AND dv.idorga = ?";
	$parms['idorga'] = (int)$params['idorga'];
}

if(isset($params['essai']) && $params['essai'] !='0')
{
	$essai = $params['essai'];
}
else
{
	$essai = 0;//Par défaut 0, si pas de résultats en bdd, recherche automatique
}
//echo $essai;
$smarty->assign('recup_div',
		$this->CreateLink($id, 'retrieve_divisions',$returnid, $contents="Récupérer les divisions",array("idepreuve"=>$params['idepreuve'], "idorga"=>$params['idorga'])));	

$query.=" ORDER BY dv.libelle ASC";
//echo $query;
$dbresult= $db->Execute($query,$parms);

if (!$dbresult)
{

		die('FATAL SQL ERROR: '.$db->ErrorMsg().'<br/>QUERY2: '.$db->sql);

}

$rowarray= array ();
$rowclass = '';
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
    {
		//pour l'accès auto aux tours ou poules
		//$tours = $ret->retrieve_div_tours ($params['idepreuve'],$row['iddivision']);
		$scope = $row['scope'];
		if($scope=='F'){$niveau ='National';}
		if($scope=='Z'){$niveau ='Zone';}
		if($scope=='L'){$niveau ='Régional';}
		if($scope=='D'){$niveau ='Départemental';}
		$indivs = $row['indivs'];
		$uploaded = $row['uploaded'];
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		$onerow->id= $row['id'];
		$onerow->idorga = $row['idorga'];
		$onerow->idepreuve= $row['idepreuve'];
		$onerow->iddivision= $row['iddivision'];
		$onerow->name= $row['name'];
		$onerow->libelle= $row['libelle'];
		$onerow->indivs = $row['indivs'];
		$onerow->scope = $niveau;
		//$onerow->uploaded = $row['uploaded'];
		if($uploaded ==1)
		{
			$onerow->uploaded= $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('already_downloaded'), '', '', 'systemicon');
		}
		else
		{
			$onerow->uploaded= $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('not_already_downloaded'), '', '', 'systemicon');
		}
	
	//$onerow->poule= $this->CreateLink($id, 'retrieve_div_results', $returnid, 'Poules',array("direction"=>"tour","idepreuve"=>$row['idepreuve'], "iddivision"=>$row['iddivision'],"indivs"=>$row['indivs']));
	$onerow->poule= $this->CreateLink($id, 'admin_poules', $returnid, 'Accès aux poules',array("idepreuve"=>$row['idepreuve'],"idorga"=>$params['idorga']));
	
	$onerow->editlink= $this->CreateLink($id, 'edit_results', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array('record_id'=>$row['id']));
	
	
	if($this->CheckPermission('Ping Delete'))
	{
		$onerow->deletelink= $this->CreateLink($id, 'delete', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete_all_div'), '', '', 'systemicon'), array('record_id'=>$row['iddivision'],'type_compet'=>'division'), $this->Lang('delete_all_div'));
	}
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
  else //il n'y a pas de résultats, on va les chercher
  {
	if($essai == '0')
	{
		$this->Redirect($id,'retrieve',$returnid, array("retrieve"=>"divisions","idepreuve"=>$params['idepreuve'], "idorga"=>$params['idorga']));	
		
	}
  }
if($essai ==1 && $dbresult->RecordCount() ==0)
{
	$smarty->assign("alert_message","Pas de résultats disponibles");
}
$smarty->assign('itemsfound', $this->Lang('sheetsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('tours',
		$this->CreateLink($id,'admin_poules', $returnid,'Tours', array("idepreuve"=>$params['idepreuve'])));
$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Supprimer"=>"supp_div","Récupérer les tours"=>"retrieve_div_tours", "Dater"=>"dater");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));

echo $this->ProcessTemplate('divisions.tpl');


#
# EOF
#
?>
