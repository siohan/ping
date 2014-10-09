<?php

if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
if (!$this->CheckPermission('Ping Manage'))
  {
    echo $this->ShowErrors($this->Lang('needpermission'));
	return;
   
  }

$licence = '';
if( !isset( $params['licence'] ) || $params['licence'] == '')  
{
	$this->SetMessage('Il manque la licence');
	$this->RedirectToAdminTab('joueurs');
/*	
$query = "SELECT CONCAT_WS(' ', nom, prenom) AS joueur, licence FROM ".cms_db_prefix()."module_ping_joueurs ORDER BY joueur ASC";
$dbresult = $db->Execute($query);
while ($dbresult && $row = $dbresult->FetchRow())
  {
    $playerlist[$row['joueur']] = $row['licence'];
}//fin du while
*/
}

 
  
$smarty->assign('formstart',
		 $this->CreateFormStart( $id, 'do_create_contact', $returnid ) );
$smarty->assign('licence',
		$this->CreateInputHidden( $id, 'licence', $params['licence'] ));
$articles = array("Téléphone fixe"=>"Téléphone fixe", "email"=>"email");
$smarty->assign('type_contact',
		$this->CreateInputDropdown($id, 'type_contact',$articles));
$smarty->assign('contact',
		$this->CreateInputText($id, 'contact',$contact));
$smarty->assign('description',
		$this->CreateInputText($id, 'description',$description,30,150));				
$smarty->assign('submit',
		$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
$smarty->assign('cancel',
		$this->CreateInputSubmit($id,'cancel',$this->Lang('cancel')));
$smarty->assign('back',
		$this->CreateInputSubmit($id,'back',$this->Lang('back')));
$smarty->assign('formend',
		$this->CreateFormEnd());


echo $this->ProcessTemplate('create_contact.tpl');

#
# EOF
#
?>
