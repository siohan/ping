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

$record_id = '';
if( !isset( $params['record_id'] ) || $params['record_id'] == '')    
{
	
	$params['message'] = $this->Lang('error_insufficientparams');
	    $params['error'] = 1;
	    $this->Redirect( $id, 'defaultadmin', $returnid, $params );
	    return;
}

//les organismes
$fede = '100001';
$zone = $this->GetPreference('zone');
$ligue = $this->GetPreference('ligue');
$dep = $this->GetPreference('dep');
$tableau = array("Fédération"=>$fede, "Zone"=>$zone,"Ligue"=>$ligue, "Comité"=>$dep);
    // 
    $query = "SELECT * FROM ".cms_db_prefix()."module_ping_type_competitions WHERE id = ?";
    $dbresult = $db->GetRow($query, array( $params['record_id'] ));

	if( !$dbresult)
    	{
		$this->SetError($this->Lang('error_resultnotfound'));
		$this->RedirectToAdminTab(results, $params);
		return;
     	}
	else
	{
		$id = $dbresult['id'];
		$name = $dbresult['name'];
		$code_compet = $dbresult['code_compet'];
		$coefficient = $dbresult['coefficient'];
		$indivs = $dbresult['indivs'];
		$idorga = $dbresult['idorga'];		
	}

   
$smarty->assign('formstart',
		    $this->CreateFormStart( $id, 'do_add_type_compet', $returnid ) );
$smarty->assign('record_id',
		$this->CreateInputText( $id, 'record_id', $params['record_id'] ));
$smarty->assign('submit',
		$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
$smarty->assign('name',
		$this->CreateInputText($id,'name',$name,115,200));
		
$smarty->assign('code_compet',
		$this->CreateInputHidden($id,'code_compet',$code_compet,5,10));

$smarty->assign('coefficient',
		$this->CreateInputText($id, 'coefficient',$coefficient,5,10));
		$itemsindivs = array("Non"=>"0","Oui"=>"1");
$smarty->assign('indivs',
		$this->CreateInputDropdown($id, 'indivs',$itemsindivs,-1,$indivs));
		$smarty->assign('orga',
				$this->CreateInputDropdown($id, 'idorga',$tableau,-1,$idorga));
$smarty->assign('edit',
		$this->CreateInputText($id,'edit','Oui'));							
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


echo $this->ProcessTemplate('edit_type_compet.tpl');

#
# EOF
#
?>
