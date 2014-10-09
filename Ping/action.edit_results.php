<?php

if( !isset($gCms) ) exit;

if (!$this->CheckPermission('Ping Manage'))
  {
    echo $this->ShowErrors($this->Lang('needpermission'));
	return;
   
  }
if( isset($params['cancel']) )
  {
    $this->RedirectToAdminTab('rencontres');
    return;
  }

$this->SetCurrentTab('users');
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

    // find the user
    $query = "SELECT * FROM ".cms_db_prefix()."module_ping_points WHERE id = ?";
    $dbresult = $db->GetRow($query, array( $params['record_id'] ));
    if( !$dbresult)
      {
	$this->SetError($this->Lang('error_resultnotfound'));
	$this->RedirectToAdminTab(results, $params);
	return;
      }
	else
	{
		$type_compet = $dbresult['type_compet'];
		$tour = $dbresult['tour'];
		$equipe = $dbresult['equipe'];
		$joueur = $dbresult['joueur'];
		$pts_joueur = $dbresult['pts_joueur'];
		$adversaire = $dbresult['adversaire'];
		$pts_adversaire = $dbresult['pts_adversaire'];
		$vic_def = $dbresult['vic_def'];
		$points = $dbresult['points'];
		
}

   
    $smarty->assign('formstart',
		    $this->CreateFormStart( $id, 'do_edit_result', $returnid ) );
    $smarty->assign('record_id',
		    $this->CreateInputHidden( $id, 'record_id', $params['record_id'] ));

   
$smarty->assign('type_compet',
				$this->CreateInputText($id,'type_compet',$type_compet,5,10));
$smarty->assign('prompt_tour',
		$this->Lang('tour'));
$smarty->assign('tour',
		$this->CreateInputText($id,'tour',$tour,5,10));
$smarty->assign('prompt_equipe',
		$this->Lang('equipe'));
$smarty->assign('equipe',
		$this->CreateInputText($id, 'equipe',$equipe,30,150));
/**/

$smarty->assign('prompt_joueur',
		$this->Lang('joueur'));
$smarty->assign('joueur',
		$this->CreateInputText($id, 'joueur',$joueur,30,80));

$smarty->assign('pts_joueur',
		$this->CreateInputText($id, 'pts_joueur',$pts_joueur,10,80));
					
$smarty->assign('prompt_adversaire',
		$this->Lang('adversaire'));
$smarty->assign('adversaire',
		$this->CreateInputText($id, 'adversaire',$adversaire,80,150));
		$smarty->assign('pts_adversaire',
				$this->CreateInputText($id, 'pts_adversaire',$pts_adversaire,10,150));
					
$smarty->assign('prompt_victoire_defaite',
		$this->Lang('vic_def'));
		
		$smarty->assign('vic_def',
				$this->CreateInputDropdown($id, 'vic_def',$items = array("V"=>"1","D"=>"0"),$selectedindex=$vic_def, $selectedvalue=$vic_def,5));
/*		
$smarty->assign('vic_def',
		$this->CreateInputText($id, 'vic_def',$vic_def,5,10));
*/
$smarty->assign('prompt_points',
		$this->Lang('points'));
$smarty->assign('points',
		$this->CreateInputText($id, 'points',$points,80,150));					
															
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


echo $this->ProcessTemplate('editresult.tpl');

#
# EOF
#
?>
