<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');

$saison = $this->GetPreference('saison_en_cours');

$db =& $this->GetDb();
global $themeObject;

$smarty->assign('id', $this->Lang('id'));
$smarty->assign('equipe', 'Equipe');
$smarty->assign('tour', 'Tour');
$smarty->assign('joueur', 'Joueur');
$smarty->assign('adversaire', 'Adversaire');
$smarty->assign('victoire', 'Vic/déf');
$smarty->assign('points', 'Points');

$result= array ();
//$query= "SELECT * FROM ".cms_db_prefix()."module_ping_points WHERE joueur = ? ORDER BY id ASC";
//$query = "SELECT type_compet, joueur, sum(vic_def) AS victoires, sum(points) AS total, count(*) AS sur FROM ".cms_db_prefix()."module_ping_points  GROUP BY joueur,type_compet ORDER BY joueur,type_compet";
$query = "SELECT sp.id,CONCAT_WS(' ',j.nom, j.prenom) AS joueur, sp.date_event, sp.epreuve, sp.nom AS name, sp.classement, sp.victoire, sp.ecart, sp.coeff, sp.pointres, sp.forfait FROM ".cms_db_prefix()."module_ping_joueurs AS j, ".cms_db_prefix()."module_ping_parties_spid AS sp  WHERE j.licence = sp.licence AND sp.saison = ? ORDER BY joueur ASC";//"  GROUP BY joueur,type_compet ORDER BY joueur,type_compet";
$dbresult= $db->Execute($query, array($saison));
//echo $query;
$rowclass= 'row1';
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->id= $row['id'];
	$onerow->joueur= $row['joueur'];//$this->CreateLink($id, 'view_user_results', $returnid, $row['joueur'],array('joueur'=>$row['joueur']),$row) ;
	$onerow->date_event= $row['date_event'];
	$onerow->epreuve= $row['epreuve'];
	$onerow->name= $row['name'];
	$onerow->classement= $row['classement'];
	$onerow->victoire= $row['victoire'];
	$onerow->ecart= $row['ecart'];
	$onerow->coeff= $row['coeff'];
	$onerow->pointres= $row['pointres'];
	$onerow->forfait= $row['forfait'];
	$onerow->select = $this->CreateInputCheckbox($id,'sel[]',$row['id']);
	$onerow->editlink= $this->CreateLink($id, 'edit_player_results', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array('record_id'=>$row['id']));
	$onerow->deletelink= $this->CreateLink($id, 'delete_result', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_user_confirm'));
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
/**/
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('createlink', 
		$this->CreateLink($id, 'create_new_user3', $returnid,
				  $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('addnewsheet'), '', '', 'systemicon')).
		$this->CreateLink($id, 'create_new_user3', $returnid, 
				  $this->Lang('addnewsheet'), 
				  array()));
$smarty->assign('retrieve_all', 
		$this->CreateLink($id, 'retrieve_all_parties_spid', $returnid,
				$themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('long_import'), '', '', 'systemicon')).
				$this->CreateLink($id, 'retrieve_all_parties_spid', $returnid, 
								  $this->Lang('retrieveallpartiesspid'), 
								  array()));
$smarty->assign('form2start',
		$this->CreateFormStart($id,'mass_action',$returnid));
$smarty->assign('form2end',
		$this->CreateFormEnd());
$articles = array("Mettre le Coeff à 0,5"=>"coeff05","Mettre le Coeff à 0,75"=>"coeff075","Mettre le Coeff à 1"=>"coeff1","Mettre le Coeff à 1,25"=>"coeff125","Mettre le Coeff à 1,5"=>"coeff15", "Récupérer situation mensuelle"=>"situation");
$smarty->assign('actiondemasse',
		$this->CreateInputDropdown($id,'actiondemasse',$articles));
$smarty->assign('submit_massaction',
		$this->CreateInputSubmit($id,'submit_massaction',$this->Lang('apply_to_selection'),'','',$this->Lang('areyousure_actionmultiple')));

			
//faire apparaitre les points totaux et somme victoire en bas ? Ce serait pas mal
/**/
echo $this->ProcessTemplate('globaluserresults.tpl');


#
# EOF
#
?>