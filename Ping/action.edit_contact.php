<?php

if( !isset($gCms) ) exit;
debug_display($params, 'Parameters');
if (!$this->CheckPermission('Ping Manage'))
  {
    echo $this->ShowErrors($this->Lang('needpermission'));
	return;
   
  }

$id_record = '';
if( !isset( $params['id_record'] ) || $params['id_record'] == '' )  
{
	$this->SetMessage('Il manque l\identifiant de la ligne');
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

$query = "SELECT * FROM ".cms_db_prefix()."module_ping_comm WHERE id = ?";
$dbresult = $db->Execute($query, array($params['id_record']));
while($dbresult && $row = $dbresult->FetchRow())
{
	$licence = $row['licence'];
	$type_contact = $row['type_contact'];
	$contact = $row['contact'];
	$description = $row['description'];
	
}
  
$smarty->assign('formstart',
		 $this->CreateFormStart( $id, 'do_create_contact', $returnid ) );
$smarty->assign('id',
		$this->CreateInputHidden( $id, 'id_record', $params['id_record'] ));
$smarty->assign('licence',
		$this->CreateInputHidden( $id, 'licence', $licence ));
$articles = array("Téléphone fixe"=>"Téléphone fixe", "email"=>"email");
$smarty->assign('type_contact',
		$this->CreateInputDropdown($id, 'type_contact',$articles,-1,$type_contact));
$smarty->assign('contact',
		$this->CreateInputText($id, 'contact',$contact,50,150));
$smarty->assign('description',
		$this->CreateInputText($id, 'description',$description,30,150));				
$smarty->assign('submitedit',
		$this->CreateInputSubmit($id, 'submitedit', $this->Lang('submit'), 'class="button"'));
$smarty->assign('cancel',
		$this->CreateInputSubmit($id,'cancel',$this->Lang('cancel')));
$smarty->assign('back',
		$this->CreateInputSubmit($id,'back',$this->Lang('back')));
$smarty->assign('formend',
		$this->CreateFormEnd());


echo $this->ProcessTemplate('edit_contact.tpl');

#
# EOF
#
?>
