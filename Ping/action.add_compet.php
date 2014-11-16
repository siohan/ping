<?php

if( !isset($gCms) ) exit;

	if (!$this->CheckPermission('Ping Manage'))
  	{
    		echo $this->ShowErrors($this->Lang('needpermission'));
		return;
   
  	}

	if( isset($params['cancel']) )
  	{
    		$this->RedirectToAdminTab('compets');
    		return;
  	}
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
//s'agit-il d'une modif ou d'une créa ?
$record_id = '';

	if(isset($params['record_id']) && $params['record_id'] !="")
	{
		//ON VA CHERCHER l'enregistrement en question
		$query = "SELECT * FROM ".cms_db_prefix()."module_ping_calendrier WHERE id = ?";
		$dbresult = $db->Execute($query, array($record_id));
		while ($dbresult && $row = $dbresult->FetchRow())
			{
				$type_compet_selected = $row['type_compet'];
				$date_debut = $row['date_debut'];
				$date_fin = $row['date_fin'];
				$numjourn = $row['numjourn'];
				
				
				
			}
			$query = "SELECT name, code_compet FROM ".cms_db_prefix()."module_ping_type_competitions";
			$dbresult = $db->Execute($query);

				if($dbresult && $dbresult >0)
				{
					while($row= $dbresult->FetchRow())
					{
						$type_compet[$row['name']] = $row['code_compet'];
					}
				}


			$smarty->assign('formstart',
					    $this->CreateFormStart( $id, 'do_add_compet', $returnid ) );
			$smarty->assign('type_compet',
					$this->CreateInputDropdown($id,'type_compet',$type_compet,$selectedindex = $type_compet,$selectedvalue=$type_compet_selected));
			$smarty->assign('date_debut',
					$this->CreateInputDate($id, 'date_debut',$date_debut));
			$smarty->assign('date_fin',
					$this->CreateInputDate($id, 'date_fin',$date_fin));
			$smarty->assign('numjourn',
					$this->CreateInputText($id,'numjourn',$numjourn,3,5));	
			$smarty->assign('submit',
					$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
			$smarty->assign('cancel',
					$this->CreateInputSubmit($id,'cancel',
								$this->Lang('cancel')));
			$smarty->assign('back',
					$this->CreateInputSubmit($id,'back',
								$this->ang('back')));

			$smarty->assign('formend',
					$this->CreateFormEnd());
	}
	else
	{
		echo "pb !";
	}
	
	



echo $this->ProcessTemplate('add_compet.tpl');

#
# EOF
#
?>
