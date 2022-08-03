<?php
if( !isset($gCms) ) exit;
####################################################################
##                                                                ##
####################################################################
//debug_display($params, 'Parameters');

$idepreuve = '';
$designation = '';
$rowarray = array();
$saison = $this->GetPreference('saison_en_cours');

	if(!isset($params['idepreuve']) || $params['idepreuve'] == '')
	{
		$this->SetMessage("parametres manquants");
		$this->RedirectToAdminTab('compets');
	}
	else
	{
		$idepreuve = $params['idepreuve'];
	}
	
	if(isset($params['iddivision']) && $params['iddivision'] != '')
	{
		$iddivision = $params['iddivision'];
	}
	if(isset($params['idorga']) && $params['idorga'] != '')
	{
		$idorga = $params['idorga'];
	}
	if(isset($params['tour']) && $params['tour'] != '')
	{
		$tour = $params['tour'];
	}
	if(isset($params['tableau']) && $params['tableau'] != '')
	{
		$tableau = $params['tableau'];
	}
	
$db = $this->GetDb();
$query = "SELECT licence FROM ".cms_db_prefix()."module_ping_participe  WHERE idepreuve = ? AND saison = ?";
echo $query;
$dbresult = $db->Execute($query, array($idepreuve, $saison));

	if(!$dbresult)
	{
		$designation.= $db->ErrorMsg();
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('compets');
	}

	$smarty->assign('formstart',
			$this->CreateFormStart( $id, 'do_participe_tours', $returnid ) );
	$smarty->assign('idepreuve',
			$this->CreateInputText($id,'idepreuve',$idepreuve,10,15));
	$smarty->assign('iddivision',
			$this->CreateInputText($id,'iddivision',$iddivision,10,15));
	$smarty->assign('idorga',
			$this->CreateInputText($id,'idorga',$idorga,10,15));
	$smarty->assign('tour',
			$this->CreateInputText($id,'tour',$tour,10,15));
	$smarty->assign('tableau',
			$this->CreateInputText($id,'tableau',$tableau,10,15));	
	if($dbresult && $dbresult->RecordCount()>0)
	{
		
		$ping_ops = new ping_admin_ops();
		while($row = $dbresult->FetchRow())
		{
			//var_dump($row);
			
			$licence = $row['licence'];
			$joueur = $ping_ops->name($licence);
			//$row['joueur'];
			$rowarray[$licence]['name'] = $joueur;
			$rowarray[$licence]['participe'] = false;
			
			//on va chercher si le joueur est déjà dans la table participe
			$query2 = "SELECT licence, idepreuve, iddivision, idorga, tour, tableau FROM ".cms_db_prefix()."module_ping_participe_tours WHERE licence = ? AND idepreuve = ? AND iddivision= ? AND idorga = ? AND tour = ? AND tableau = ?";
			//echo $query2;
			$dbresultat = $db->Execute($query2, array($licence, $idepreuve, $iddivision,$idorga, $tour, $tableau));
			
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
echo $this->ProcessTemplate('participe_tours.tpl');
#
#EOF
#
?>