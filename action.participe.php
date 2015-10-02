<?php
if( !isset($gCms) ) exit;
####################################################################
##                                                                ##
####################################################################
//debug_display($params, 'Parameters');
$type_compet = '';
$designation = '';
$rowarray = array();

	if(!isset($params['type_compet']) || $params['type_compet'] == '')
	{
		$this->SetMessage("parametres manquants");
		$this->RedirectToAdminTab('compets');
	}
	else
	{
		$type_compet = $params['type_compet'];
	}
	if(!isset($params['date_debut']) || $params['date_debut'] == '')
	{
		$this->SetMessage("parametres manquants");
		$this->RedirectToAdminTab('compets');
	}
	else
	{
		$date_debut = $params['date_debut'];
	}
	if(!isset($params['date_fin']) || $params['date_fin'] == '')
	{
		$this->SetMessage("parametres manquants");
		$this->RedirectToAdminTab('compets');
	}
	else
	{
		$date_fin = $params['date_fin'];
	}
	
$db = $this->GetDb();
$query = "SELECT j.licence, CONCAT_WS(' ',j.nom, j.prenom ) AS joueur FROM ".cms_db_prefix()."module_ping_joueurs AS j WHERE j.actif = '1' ";
//echo $query;
$dbresult = $db->Execute($query);

	if(!$dbresult)
	{
		$designation.= $db->ErrorMsg();
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('compets');
	}

	$smarty->assign('formstart',
			$this->CreateFormStart( $id, 'do_participe', $returnid ) );
	$smarty->assign('type_compet',
			$this->CreateInputText($id,'type_compet',$type_compet,10,15));
	$smarty->assign('date_debut',
			$this->CreateInputText($id,'date_debut',$date_debut,10,15));
	$smarty->assign('date_fin',
			$this->CreateInputText($id,'date_fin',$date_fin,10,15));	
	if($dbresult && $dbresult->RecordCount()>0)
	{
		while($row = $dbresult->FetchRow())
		{
			//var_dump($row);
			
			$licence = $row['licence'];
			$joueur = $row['joueur'];
			$rowarray[$licence]['name'] = $joueur;
			$rowarray[$licence]['participe'] = false;
			
			//on va chercher si le joueur est déjà dans la table participe
			$query2 = "SELECT licence, type_compet FROM ".cms_db_prefix()."module_ping_participe WHERE licence = ? AND type_compet = ? AND date_debut BETWEEN ? AND ?";
			//echo $query2;
			$dbresultat = $db->Execute($query2, array($licence, $type_compet, $date_debut,$date_fin));
			
			if($dbresultat->RecordCount()>0)
			{
				while($row2 = $dbresultat->FetchRow())
				{
			
				
					$rowarray[$licence]['participe'] = true;
				}
			}//print_r($rowarray);
			
			
						
			
			
		}
		$smarty->assign('rowarray',$rowarray);	
			
	}
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
echo $this->ProcessTemplate('participe.tpl');
#
#EOF
#
?>