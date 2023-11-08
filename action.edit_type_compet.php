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
$db = cmsms()->GetDb();

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
		$idepreuve = $dbresult['idepreuve'];	
	}

   


echo $this->ProcessTemplate('edit_type_compet.tpl');

#
# EOF
#
?>
