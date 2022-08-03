<?php
if( !isset($gCms) ) exit;
####################################################################
##                                                                ##
####################################################################
//debug_display($params, 'Parameters');
$type_compet = '';
$idepreuve = '';
$designation = '';
$rowarray = array();

	if(!isset($params['idepreuve']) || $params['idepreuve'] == '')
	{
		$this->SetMessage("parametres manquants");
		$this->RedirectToAdminTab('compets');
	}
	else
	{
		$idepreuve = $params['idepreuve'];
	}
	
	
$db = $this->GetDb();
$query = "SELECT j.licence, CONCAT_WS(' ',j.nom, j.prenom ) AS joueur FROM ".cms_db_prefix()."module_ping_joueurs AS j WHERE actif = 1 AND type = 'T' ORDER BY j.nom ASC ";
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
	$smarty->assign('idepreuve',
			$this->CreateInputText($id,'idepreuve',$idepreuve,10,15));
	
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
			$query2 = "SELECT licence, idepreuve FROM ".cms_db_prefix()."module_ping_participe_tours WHERE licence = ? AND idepreuve = ?";
			//echo $query2;
			$dbresultat = $db->Execute($query2, array($licence, $idepreuve));
			
			if($dbresultat->RecordCount()>0)
			{
				while($row2 = $dbresultat->FetchRow())
				{
			
				
					$rowarray[$licence]['participe'] = true;
				}
			}
			//print_r($rowarray);
			
			
						
			
			
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