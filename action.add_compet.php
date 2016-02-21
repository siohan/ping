<?php

if( !isset($gCms) ) exit;

	if (!$this->CheckPermission('Ping Manage'))
  	{
    		echo $this->ShowErrors($this->Lang('needpermission'));
		return;
   
  	}

	if( isset($params['cancel']) )
  	{
    		$this->RedirectToAdminTab('compets');
    		return;
  	}
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
//s'agit-il d'une modif ou d'une créa ?
$record_id = '';
$type_compet_selected = '';
$date_debut = '';
$date_fin = '';
$numjourn = '0';
$edit = 0;

	if(isset($params['record_id']) && $params['record_id'] !="")
	{
		$record_id = $params['record_id'];
		$edit = 1;//on est bien en trai d'éditer un enregistrement
		//ON VA CHERCHER l'enregistrement en question
		$query = "SELECT cal.id, tc.id AS index1, tc.idepreuve, tc.name,tc.indivs, cal.date_debut, cal.date_fin, cal.numjourn FROM ".cms_db_prefix()."module_ping_calendrier AS cal, ".cms_db_prefix()."module_ping_type_competitions AS tc WHERE cal.idepreuve = tc.idepreuve AND cal.id = ?";
		$dbresult = $db->Execute($query, array($record_id));
		while ($dbresult && $row = $dbresult->FetchRow())
			{
				$type_compet_selected = $row['idepreuve'];
				$date_debut = $row['date_debut'];
				$date_fin = $row['date_fin'];
				$numjourn = $row['numjourn'];
				$name = $row['name'];
				$indivs = $row['indivs'];
				$index = $row['index1'] - 1;
				//$idepreuve = $row['idepreuve'];
				
				
				
			}
	}
	//on fait une requete pour completer l'input dropdown du formulaire
	$query = "SELECT name, idepreuve,indivs FROM ".cms_db_prefix()."module_ping_type_competitions";
	$dbresult = $db->Execute($query);

		if($dbresult && $dbresult->RecordCount() >0)
		{
			while($row= $dbresult->FetchRow())
			{
				$type_compet[$row['name']] = $row['idepreuve'];
				$indivs = $row['indivs'];
			}
		}


			
	
	//on construit le formulaire
	$smarty->assign('formstart',
			    $this->CreateFormStart( $id, 'do_add_compet', $returnid ) );
	if($edit==1)
	{
		$smarty->assign('record_id',
				$this->CreateInputHidden($id,'record_id',$record_id));
	}
	$smarty->assign('idepreuve',
			$this->CreateInputDropdown($id,'idepreuve',$type_compet,$selectedindex = $index, $selectedvalue=$name));
	$smarty->assign('date_debut',
			$this->CreateInputDate($id, 'date_debut',$date_debut));
	$smarty->assign('date_fin',
			$this->CreateInputDate($id, 'date_fin',$date_fin));
	$smarty->assign('numjourn',
			$this->CreateInputText($id,'numjourn',$numjourn,3,5));
	$smarty->assign('indivs',
			$this->CreateInputHidden($id,'indivs',$indivs,3,5));	
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
	
	



echo $this->ProcessTemplate('add_compet.tpl');

#
# EOF
#
?>
