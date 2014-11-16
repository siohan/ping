<?php

if( !isset($gCms) ) exit;

if (isset($params['submit_massdelete']) )
  {
     if( isset($params['sel']) && is_array($params['sel']) &&
	count($params['sel']) > 0 )
      {
        foreach( $params['sel'] as $news_id )
	  {
	    ping_admin_ops::delete_article( $news_id );
	  }
      }
  }


$db =& $this->GetDb();
global $themeObject;
//liste des liens pour récupérer les données 
$smarty->assign('retrieve_users',
		$this->CreateLink($id, 'retrieve_joueurs_by_club', $returnid, $contents = "Récupération des joueurs", $warn_message = "Etes vous sûr ? Trop d'appels vers la base de données peuvent avoir des conséquences importantes !"));
		
$smarty->assign('retrieve_teams',
		$this->CreateLink($id, 'retrieve_teams', $returnid, $contents = "Récupération des équipes (championnat seniors)", array('type'=>'M')));
$smarty->assign('retrieve_teams_autres',
		$this->CreateLink($id, 'retrieve_teams', $returnid, $contents = "Récupération des équipes"));
$smarty->assign('retrieve_all_parties',
		$this->CreateLink($id, 'retrieve_all_parties', $returnid, $contents = "Récupération de toutes les parties FFTT"));
$smarty->assign('recup_joueurs',
		$this->CreateLink($id, 'recup_joueurs', $returnid));

$smarty->assign('retrieve_all_spid',
		$this->CreateLink($id, 'retrieve_all_parties_spid', $returnid, $contents = 'Récupérations de toutes les parties SPID', $warn_message = 'Etes vous sûr ?'));
$smarty->assign('retrieve_details_rencontres',
		$this->CreateLink($id, 'retrieve_club', $returnid, $contents = 'Récupérations du détail des rencontres'));



$result= array ();
$query= "SELECT * FROM ".cms_db_prefix()."module_ping_recup ORDER BY id DESC";
$dbresult= $db->Execute($query);
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
	$onerow->datemaj= $row['datemaj'];
	$onerow->designation= $row['designation'];
	$onerow->action= $row['action'];
	if($actif == 1)
	{
		$onerow->deletelink= $this->CreateLink($id, 'delete_user', $returnid, $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_result_confirm'));
	}
	else {
		$onerow->deletelink= $this->CreateLink($id, 'delete_user', $returnid, $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_result_confirm'));
	}
	$onerow->editlink= $this->CreateLink($id, $row['action'], $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'),$this->Lang('retrieve_users_confirm'));
	$onerow->deletelink= $this->CreateLink($id, 'delete_user', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('record_id'=>$row['id']), $this->Lang('delete_result_confirm'));
	$onerow->select = $this->CreateInputCheckbox($id,'sel[]',$row['id']);
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }
$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);
$smarty->assign('createlink', 
		$this->CreateLink($id, 'add_compte', $returnid,
				  $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('add'), '', '', 'systemicon')).
		$this->CreateLink($id, 'add_compte', $returnid, 
				  $this->Lang('addnewsheet'), 
				  array()));
$smarty->assign('submit_massdelete',
		$this->CreateInputSubmit($id,'submit_massdelete',$this->Lang('delete_selected'),
									     '','',$this->Lang('areyousure_deletemultiple')));
echo $this->ProcessTemplate('recupJoueurs.tpl');


#
# EOF
#
?>