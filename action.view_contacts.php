<?php

if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
if (!$this->CheckPermission('Ping Manage'))
  {
    echo $this->ShowErrors($this->Lang('needpermission'));
	return;
   
  }

$this->SetCurrentTab('joueurs');
$db =& $this->GetDb();
global $themeObject;
//$record_id = $params['record_id'];
if( isset( $params['message'] ) )
  {
    $smarty->assign('message',html_entity_decode($params['message']));
  }
if( isset( $params['error'] ) )
  {
    $smarty->assign('error',html_entity_decode($params['error']));
  }



$licence = '';
if( !isset( $params['licence'] ) || $params['licence'] == '')    
{
	
	$params['message'] = $this->Lang('error_insufficientparams');
	    $params['error'] = 1;
	    $this->Redirect( $id, 'defaultadmin', $returnid, $params );
	    return;
}

    // find the user
    $query = "SELECT * FROM ".cms_db_prefix()."module_ping_comm WHERE licence = ?";
    $dbresult = $db->Execute($query, array( $params['licence'] ));
    $rowclass= 'row1';
$rowarray= array ();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
    while ($row= $dbresult->FetchRow())
      {
	$actif = $row['actif'];
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$onerow->id= $row['id'];
	$onerow->type_contact= $row['type_contact'];
	$onerow->contact= $row['contact'];
	$onerow->description= $row['description'];
	$onerow->create_contact= $this->CreateLink($id,'edit_contact', $returnid,$themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('create_contact'), '', '', 'systemicon'),array('id_record'=>$row['id']));
	$onerow->doedit= $this->CreateLink($id, 'edit_joueur', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'),array('licence'=>$row['licence']));
	$onerow->deletelink= $this->CreateLink($id, 'delete_contact', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_result_confirm'));
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('create_new_contact',
		$this->CreateLink($id,'create_contact',$returnid,'Créer un nouveau contact', array('licence'=>$params['licence'])));
$smarty->assign('createlink', 
		$this->CreateLink($id, 'create_contact', $returnid,
				  $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('create_contact'), '', '', 'systemicon')).
		$this->CreateLink($id, 'create_contact', $returnid, 
				  $this->Lang('create_contact'), 
				  array()));


echo $this->ProcessTemplate('contacts.tpl');

#
# EOF
#
?>
