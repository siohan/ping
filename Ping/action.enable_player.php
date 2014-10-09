<?php

if( !isset($gCms) ) exit;

if (!$this->CheckPermission('Ping Manage'))
  {
    echo $this->ShowErrors($this->Lang('needpermission'));
	return;
   
  }


$db =& $this->GetDb();
//$record_id = $params['record_id'];

$licence = '';
if( !isset( $params['licence'] ) || $params['licence'] == '')    
{
	
	$this->SetMessage("Licence absente");
		$this->RedirectToAdminTab('joueurs');
}

    // find the user
    $query = "UPDATE ".cms_db_prefix()."module_ping_joueurs SET actif ='1'  WHERE licence = ?";
    $dbresult = $db->Execute($query, array( $params['licence'] ));
    if($dbresult)
      
	{
		$this->SetMessage("Joueur réactivé");
			$this->RedirectToAdminTab('joueurs');
		
	}


#
# EOF
#
?>
