<?php

if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
if (!$this->CheckPermission('Ping Manage'))
  {
    echo $this->ShowErrors($this->Lang('needpermission'));
	return;
   
  }

$this->SetCurrentTab('results');
$db =& $this->GetDb();
//$record_id = $params['record_id'];
if( isset( $params['message'] ) )
  {
    $smarty->assign('message',html_entity_decode($params['message']));
  }
if( isset( $params['error'] ) )
  {
    $smarty->assign('error',html_entity_decode($params['error']));
  }



$record_id = '';
if( !isset( $params['record_id'] ) || $params['record_id'] == '')    
{
	
	$params['message'] = $this->Lang('error_insufficientparams');
	    $params['error'] = 1;
	    $this->Redirect( $id, 'defaultadmin', $returnid, $params );
	    return;
}
else
{
	$record_id = $params['record_id'];
}

    // find the user
    $query = "SELECT * FROM ".cms_db_prefix()."module_ping_parties_spid AS s, ".cms_db_prefix()."module_ping_type_competitions AS tc WHERE s.epreuve = tc.name AND s.id = ?";
    $dbresult = $db->GetRow($query, array( $params['record_id'] ));
    if( !$dbresult)
      {
	$this->SetMessage($this->Lang('error_resultnotfound'));
	$this->RedirectToAdminTab('results');
	return;
      }
	else
	{
		$epreuve = $dbresult['epreuve'];
		$numjourn = $dbresult['numjourn'];
		//$equipe = $dbresult['equipe'];
		$nom = $dbresult['nom'];
		$classement = $dbresult['classement'];
		$ecart = $dbresult['ecart'];
		$coeff = $dbresult['coeff'];
		$victoire = $dbresult['victoire'];
		$points = $dbresult['points'];
		$forfait = $dbresult['forfait'];
		
			if($victoire ==1)
			{
				
				$selectedindex1 = 0;
				//$selectedvalue = 1;
			}
			else
			{
				$selectedindex1 = 1;
				//$selectedvalue = 0;
			}
		
		

}
   
$smarty->assign('formstart',
		    $this->CreateFormStart( $id, 'do_edit_result', $returnid ) );
$smarty->assign('record_id',
		$this->CreateInputHidden( $id, 'record_id', $params['record_id'] ));
$smarty->assign('submit',
		$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));   
$smarty->assign('epreuve',
				$this->CreateInputText($id,'epreuve',$epreuve,80,150));
$smarty->assign('prompt_tour',
		$this->Lang('tour'));
$smarty->assign('numjourn',
		$this->CreateInputText($id,'numjourn',$numjourn,5,10));
$smarty->assign('prompt_equipe',
		$this->Lang('equipe'));
$smarty->assign('nom',
		$this->CreateInputText($id, 'nom',$nom,90,150));
/**/

$smarty->assign('prompt_joueur',
		$this->Lang('joueur'));
$smarty->assign('classement',
		$this->CreateInputText($id, 'classement',$classement,30,80));

$smarty->assign('ecart',
		$this->CreateInputText($id, 'ecart',$ecart,10,80));
					
$smarty->assign('prompt_adversaire',
		$this->Lang('adversaire'));
$smarty->assign('adversaire',
		$this->CreateInputText($id, 'adversaire',$adversaire,80,150));
		$smarty->assign('pts_adversaire',
				$this->CreateInputText($id, 'pts_adversaire',$pts_adversaire,10,150));
					
$smarty->assign('prompt_victoire_defaite',
		$this->Lang('vic_def'));
		
		$smarty->assign('victoire',
				$this->CreateInputDropdown($id, 'victoire',$items = array("V"=>"1","D"=>"0"),$selectedindex = $selectedindex1, $selectedvalue=$victoire,5));
/*		
$smarty->assign('vic_def',
		$this->CreateInputText($id, 'vic_def',$vic_def,5,10));
*/
$smarty->assign('prompt_points',
		$this->Lang('points'));
		$itemscoeff = 
$smarty->assign('coeff',
		$this->CreateInputDropdown($id, 'coeff',$itemscoeff = array("0"=>"0.00", "0,5"=>"0.50","0,75"=>"0.75", "1"=>"1.00", "1,25"=>"1.25", "1,5"=>"1.50"),$selectedindex=$coeff,victoire, $selectedvalue=$coeff,5));					
															

$smarty->assign('cancel',
			$this->CreateInputSubmit($id,'cancel',
						$this->Lang('cancel')));
$smarty->assign('back',
			$this->CreateInputSubmit($id,'back',
						$this->Lang('back')));

$smarty->assign('formend',
		$this->CreateFormEnd());


echo $this->ProcessTemplate('editresult.tpl');

#
# EOF
#
?>
