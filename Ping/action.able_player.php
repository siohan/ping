<?php
####################################################################
###                       Activation/désactivation d'un joueur  ####
####################################################################
if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
if (!$this->CheckPermission('Ping Manage'))
  {
    echo $this->ShowErrors($this->Lang('needpermission'));
	return;
   
  }

$db =& $this->GetDb();
$error = '';
$licence = '';
if( isset( $params['licence'] ) && $params['licence'] != '')    
{
	$licence = $params['licence'];
}
else
{
		$error++;
}	
$actif = '';
if( isset( $params['actif']) && $params['actif'] != '')
{
	$actif = $params['actif'];
}
else
{
	$error++;
}

//on compte le nombre d'erreur
echo $error;
if($error>0)
{
	$this->SetMessage("paramètres manquants");
	$this->RedirectToAdminTab('joueurs');
}

if($params['actif'] =='1'){
	$query = "UPDATE ".cms_db_prefix()."module_ping_joueurs SET actif ='1'  WHERE licence = ?";
	$message = "Joueur activé";
}
else
{
	$query = "UPDATE ".cms_db_prefix()."module_ping_joueurs SET actif ='0'  WHERE licence = ?";
	$message = "Joueur désactivé";
}
    
    $dbresult = $db->Execute($query, array( $licence ));
    if($dbresult)
      
	{
		$this->SetMessage("$message");
		$this->RedirectToAdminTab('joueurs');
		
	}


#
# EOF
#
?>
