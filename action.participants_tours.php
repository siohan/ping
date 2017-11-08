<?php
if(!isset($gCms)) exit;
$db = cmsms()->GetDb();
global $themeObject;
//debug_display($params, 'Parameters');
$saison = $this->GetPreference('saison_en_cours');
if(isset($params['idepreuve']) && $params['idepreuve'] !='')
{
	$idepreuve = $params['idepreuve'];
}
else
{
	echo "il y a une erreur !";
}
if(isset($params['licence']) && $params['licence'] !='')
{
	$licence = $params['licence'];
}
else
{
	echo "il y a une erreur !";
}
if(isset($params['add']) && $params['add'] != '')
{
	$add = $params['add'];
}
else
{
	$add = 0;
}
// deux possibilités
# 1 - pas de résultat->on redirige vers un formulaire dynamique
# 2 - Au moins un résultat, on affiche
$ping_ops = new ping_admin_ops();
$smarty->assign('joueur', $ping_ops->name($licence));
$smarty->assign('retour', 
		$this->CreateLink($id,'participants' , $returnid, '<= Retour', array("idepreuve"=>$idepreuve)));
$smarty->assign('add', 
			$this->CreateLink($id,'participants_tours' , $returnid, 'Ajouter un tour', array("idepreuve"=>$idepreuve, "licence"=>$licence,"add"=>"1")));
$query = "SELECT CONCAT_WS(' ',j.nom, j.prenom) AS joueur , j.licence, part.iddivision, part.idorga, part.tour, part.tableau FROM ".cms_db_prefix()."module_ping_participe_tours AS part, ".cms_db_prefix()."module_ping_joueurs AS j WHERE j.licence = part.licence AND part.idepreuve = ? AND part.saison = ? AND j.licence = ?";
$query.=" ORDER BY part.tour ASC";//echo $query;
$dbresult = $db->Execute($query, array($idepreuve, $saison,$licence));
$rowarray = array();
$rowclass='row1';
if($dbresult && $dbresult->recordCount()>0 && $add !="1")
{
	while($row = $dbresult->FetchRow())
	{
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		$onerow->licence = $row['licence'];
		$onerow->libelle = $ping_ops->nom_division($idepreuve,$row['iddivision'],$saison);
		$onerow->iddivision = $row['iddivision'];
		$onerow->idorga = $row['idorga'];
		$onerow->tour = $row['tour'];
		$onerow->tableau = $row['tableau'];
		$onerow->parties = $this->CreateLink($id, 'admin',$returnid, 'Parties', array("idepreuve"=>$idepreuve, "iddivision"=>$row['iddivision'], "tableau"=>$row['tableau'], "tour"=>$row['tour'], "idorga"=>$row['idorga']) );
		$upload = $ping_ops->is_classement_uploaded($idepreuve,$row['iddivision'],$row['tableau'],$row['tour']);
		if($upload === true)
		{
			$onerow->uploaded_classement = $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'),'','','systemicon');
		}
		else
		{
			$onerow->uploaded_classement = $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'),'','','systemicon');
		}
		$onerow->classement = $this->CreateLink($id, 'admin_div_classement',$returnid, 'Classement', array("idepreuve"=>$idepreuve, "iddivision"=>$row['iddivision'], "tableau"=>$row['tableau'], "tour"=>$row['tour'], "idorga"=>$row['idorga']) );
	//	$onerow->affectation = $this->CreateLink($id, 'participants_tours',$returnid, 'Tour suivant', array("licence"=>$row['licence'], "idepreuve"=>$idepreuve, "add"=>"1") );
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
	}
	$smarty->assign('itemsfound', $this->Lang('resultsfound'));
	$smarty->assign('itemcount', count($rowarray));
	$smarty->assign('items', $rowarray);
echo $this->ProcessTemplate('participants_tours.tpl');
}
elseif($dbresult->RecordCount()==0 || $add == 1)
{
	//pas de résultat, on créé un formulaire dynamique
	//On choisit d'abord le niveau
	$smarty->assign('formstart',
			    $this->CreateFormStart( $id, 'affectation', $returnid ) );
	$smarty->assign('licence',
					$this->CreateInputText($id,'licence',$licence,12,15));
	$smarty->assign('step', $this->CreateInputHidden($id,'step',"1"));
	$smarty->assign('idepreuve',
			$this->CreateInputText($id,'idepreuve',$idepreuve,5,15));
	$smarty->assign('tour', 
				$this->CreateInputText($id,'tour','',5,15));
	$fede = '100001';
	$zone = $this->GetPreference('zone');
	$ligue = $this->GetPreference('ligue');
	$dep = $this->GetPreference('dep');
	$niveaux = array("Nationale"=>$fede,"Zone"=>$zone,"Régional"=>$ligue, "Départemental"=>$dep);
	$smarty->assign('niveau',
			$this->CreateInputDropdown($id, 'niveau',$niveaux));
	$smarty->assign('submit',
			$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
	$smarty->assign('cancel',
			$this->CreateInputSubmit($id,'cancel',
						$this->Lang('cancel')));
	$smarty->assign('back',
			$this->CreateInputSubmit($id,'back',
						$this->Lang('back')));

	$smarty->assign('formend',
			$this->CreateFormEnd());


	echo $this->ProcessTemplate('affectation_niveaux.tpl');
	
}


?>